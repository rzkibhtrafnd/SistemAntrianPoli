<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Queue;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Poli;
use Carbon\Carbon;

class QueueController extends Controller
{
    public function create(Request $request)
    {
        $patients = Patient::all();
        $polis = Poli::all();
        $doctors = collect();
        $availableTimes = [];

        $selectedPoliId = $request->input('poli_id');
        $selectedDoctorId = $request->input('doctor_id');
        $selectedTime = $request->input('schedule_time');

        if ($selectedPoliId) {
            $doctors = Doctor::where('poli_id', $selectedPoliId)->get();
        }

        if ($selectedDoctorId) {
            $doctor = Doctor::find($selectedDoctorId);
            $availableTimes = $this->getAvailableTimes($doctor);
        }

        return view('public.queue.create', compact(
            'patients', 'polis', 'doctors', 'availableTimes',
            'selectedPoliId', 'selectedDoctorId', 'selectedTime'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'registration_number' => 'required|exists:patients,registration_number',
            'poli_id' => 'required|exists:polis,id',
            'doctor_id' => 'required|exists:doctors,id',
            'schedule_time' => 'required|date_format:H:i',
        ]);

        $doctor = Doctor::findOrFail($data['doctor_id']);
        $scheduleTime = Carbon::createFromFormat('H:i', $data['schedule_time']);
        $now = now()->timezone('Asia/Jakarta');

        // Jika sudah lewat 1 jam dari jam mulai, tolak pendaftaran
        if ($now->gt($scheduleTime->copy()->addHour())) {
            return back()->withInput()->withErrors([
                'schedule_time' => 'Pendaftaran untuk jam ini sudah ditutup. Silakan daftar untuk jadwal besok.',
            ]);
        }

        if (!$this->isValidScheduleTime($doctor, $scheduleTime)) {
            return back()->withInput()->withErrors([
                'schedule_time' => 'Waktu praktek tidak tersedia'
            ]);
        }

        $queueNumber = $this->generateQueueNumber($data['poli_id']);

        $patient = Patient::where('registration_number', $data['registration_number'])->firstOrFail();

        $queue = Queue::create([
            'queue_number' => $queueNumber,
            'patient_id' => $patient->id,
            'poli_id' => $data['poli_id'],
            'doctor_id' => $data['doctor_id'],
            'schedule_time' => $scheduleTime,
            'status' => 'waiting',
            'registration_time' => $now,
        ]);

        return redirect()->route('queues.print', $queue->id)
            ->with('success', 'Pendaftaran berhasil. Nomor antrian: '.$queueNumber);
    }


    private function generateQueueNumber($poliId)
    {
        $todayCount = Queue::whereDate('registration_time', Carbon::today())
            ->where('poli_id', $poliId)
            ->count();

        return $todayCount + 1;
    }

    private function isValidScheduleTime($doctor, $time)
    {
        $now = now()->timezone('Asia/Jakarta');
        $schedule = $doctor->schedule;

        if (!$schedule || !is_array($schedule)) return false;

        $currentDay = $now->format('l'); // e.g., "Monday"

        if (!isset($schedule[$currentDay])) return false;

        [$startTime, $endTime] = $schedule[$currentDay];
        $start = Carbon::createFromFormat('H:i', $startTime);
        $end = Carbon::createFromFormat('H:i', $endTime);

        return $time->between($start, $end) && $time->gt($now);
    }

    private function getAvailableTimes($doctor)
    {
        if (!$doctor || !is_array($doctor->schedule)) return [];

        $schedule = $doctor->schedule;
        $today = now()->timezone('Asia/Jakarta')->format('l'); // e.g., "Monday"

        if (!isset($schedule[$today])) return [];

        [$startTime, $endTime] = $schedule[$today];

        $start = Carbon::createFromFormat('H:i', $startTime);
        $now = now()->timezone('Asia/Jakarta');

        // Tutup pendaftaran jika sudah lewat 1 jam dari jam mulai
        if ($now->diffInMinutes($start, false) < -60) {
            return []; // kosongkan jadwal
        }

        // Hanya tampilkan jam mulai saja
        if ($now->lt($start)) {
            return [$start->format('H:i')];
        }

        return []; // jika waktu sekarang sudah lewat jam mulai tapi belum lebih dari 1 jam
    }

    public function printTicket($id)
    {
        $queue = Queue::with(['patient', 'poli', 'doctor'])->findOrFail($id);
        return view('public.queue.ticket', compact('queue'));
    }

    public function getByPoli()
    {
        $user = Auth::user();
        $queues = Queue::with('patient', 'doctor')
            ->where('poli_id', $user->poli_id)
            ->orderBy('status')
            ->orderBy('registration_time')
            ->get();

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
}
