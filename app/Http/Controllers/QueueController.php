<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Patient;
use App\Models\Poli;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QueueController extends Controller
{
    public function create()
    {
        $polis = Poli::where('status', 'active')->get();
        return view('public.queue.create', compact('polis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_number' => 'required|exists:patients,registration_number',
            'poli_id' => 'required|exists:polis,id',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        $patient = Patient::where('registration_number', $validated['registration_number'])->firstOrFail();

        $today = now()->toDateString();

        $queueCount = Queue::where('poli_id', $validated['poli_id'])
            ->whereDate('created_at', $today)
            ->count();

        $poli = Poli::findOrFail($validated['poli_id']);
        $poliCode = strtoupper(substr($poli->name, 0, 1)); // uppercase for clarity
        $queueNumber = $poliCode . now()->format('Ymd') . str_pad($queueCount + 1, 3, '0', STR_PAD_LEFT);

        $queue = Queue::create([
            'queue_number' => $queueNumber,
            'patient_id' => $patient->id,
            'poli_id' => $validated['poli_id'],
            'doctor_id' => $validated['doctor_id'],
            'status' => 'waiting',
            'registration_time' => now(),
        ]);

        return redirect()->route('queues.print', $queue->id)->with('success', 'Pendaftaran antrian berhasil.');
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
        $poliId = Auth::user()->poli_id;

        $queue = Queue::where('poli_id', $poliId)
            ->where('status', 'waiting')
            ->orderBy('registration_time')
            ->first();

        if ($queue) {
            $queue->update([
                'status' => 'called',
                'called_time' => now()
            ]);

            return response()->json([
                'success' => true,
                'queue' => $queue->load('patient', 'poli', 'doctor'),
                'message' => 'Antrian berhasil dipanggil.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tidak ada antrian menunggu.'
        ]);
    }

    public function complete(Request $request, Queue $queue)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000'
        ]);

        $queue->update([
            'status' => 'completed',
            'finish_time' => now(),
            'notes' => $validated['notes'] ?? null
        ]);

        return redirect()->back()->with('success', 'Antrian berhasil diselesaikan.');
    }

    public function getDoctorsByPoli($poliId)
    {
        $doctors = Doctor::where('poli_id', $poliId)
            ->where('status', 'active')
            ->get();

        return response()->json($doctors);
    }
}
