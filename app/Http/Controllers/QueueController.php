<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Patient;
use App\Models\Poli;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class QueueController extends Controller
{
    public function create()
    {
        $patients = Patient::all();
        $polis = Poli::where('status', 'active')->get();
        $doctors = collect();
        $availableTimes = [];

        $selectedPoliId = request()->input('poli_id');
        $selectedDoctorId = request()->input('doctor_id');
        $selectedTime = request()->input('schedule_time');

        if ($selectedPoliId) {
            $doctors = Doctor::where('poli_id', $selectedPoliId)
                ->where('status', 'active')
                ->get();
        }

        if ($selectedDoctorId) {
            $doctor = Doctor::find($selectedDoctorId);
            $availableTimes = $doctor?->available_times ?? [];
        }

        return view('public.queue.create', compact(
            'patients', 'polis', 'doctors', 'availableTimes',
            'selectedPoliId', 'selectedDoctorId', 'selectedTime'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_number' => 'required|exists:patients,registration_number',
            'poli_id' => 'required|exists:polis,id',
            'doctor_id' => 'required|exists:doctors,id',
            'schedule_time' => 'required|date_format:H:i'
        ]);

        $patient = Patient::where('registration_number', $validated['registration_number'])->firstOrFail();
        $doctor = Doctor::findOrFail($validated['doctor_id']);

        if (!in_array($validated['schedule_time'], $doctor->available_times)) {
            return back()->withErrors(['schedule_time' => 'Waktu praktek tidak valid'])->withInput();
        }

        // Hitung jumlah antrean hari ini untuk Poli yang sama
        $queueCount = Queue::where('poli_id', $validated['poli_id'])
            ->whereDate('created_at', now())
            ->count();

        $queueNumber = $queueCount + 1;

        $queue = Queue::create([
            'queue_number' => $queueNumber,
            'patient_id' => $patient->id,
            'poli_id' => $validated['poli_id'],
            'doctor_id' => $validated['doctor_id'],
            'schedule_time' => $validated['schedule_time'],
            'status' => 'waiting',
            'registration_time' => now(),
        ]);

        return redirect()->route('queues.print', $queue->id)->with('success', 'Pendaftaran berhasil!');
    }

    public function printTicket(Queue $queue)
    {
        return view('public.queue.ticket', compact('queue'));
    }

    public function getByPoli(Request $request)
    {
        $user = Auth::user();
        $poliId = $user->poli_id;

        $today = now()->toDateString();

        $queues = Queue::with(['patient', 'doctor'])
            ->where('poli_id', $poliId)
            ->whereDate('created_at', $today)
            ->orderByRaw("FIELD(status, 'waiting', 'called', 'completed')")
            ->orderBy('registration_time')
            ->paginate(15);

        return view('staff.queue.index', compact('queues'));
    }

    public function callNext(Request $request)
    {
        $user = Auth::user();
        $nextQueue = Queue::where('poli_id', $user->poli_id)
            ->where('status', 'waiting')
            ->orderBy('registration_time')
            ->first();

        if (!$nextQueue) {
            return back()->with('error', 'Tidak ada antrian waiting');
        }

        $nextQueue->update([
            'status' => 'called',
            'called_time' => Carbon::now(),
        ]);

        return back()->with('success', "Antrian {$nextQueue->queue_number} dipanggil");
    }

    public function complete($id)
    {
        $queue = Queue::findOrFail($id);

        if (!in_array($queue->status, ['called', 'in_service'])) {
            return back()->with('error', 'Status antrian tidak valid');
        }

        $queue->update([
            'status' => 'completed',
            'finish_time' => Carbon::now(),
        ]);

        return back()->with('success', "Antrian {$queue->queue_number} selesai");
    }

    public function getDoctorsByPoli($poliId)
    {
        $doctors = Doctor::where('poli_id', $poliId)
            ->where('status', 'active')
            ->get();

        return response()->json($doctors);
    }

    public function getScheduleByDoctor($doctorId)
    {
        $doctor = Doctor::findOrFail($doctorId);
        $times = $doctor->available_times;

        if (empty($times)) {
            return response()->json([
                'error' => 'Tidak ada jadwal tersedia untuk hari ini'
            ], 404);
        }

        return response()->json($times);
    }
}
