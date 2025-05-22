<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Poli;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $polis = Poli::with(['queues' => function($query) {
            $query->whereDate('registration_time', Carbon::today())
                  ->with('patient');
        }])->get();

        return view('public.dashboard', [
            'polis' => $polis,
            'initialData' => $this->getQueueData()
        ]);
    }

    public function getQueueStatus()
    {
        return response()->json($this->getQueueData());
    }

    private function getQueueData()
{
    $today = Carbon::today();

    // Ambil statistik global
    $globalStats = Queue::selectRaw("
        COUNT(*) as total_patients,
        SUM(CASE WHEN status = 'waiting' THEN 1 ELSE 0 END) as waiting_count,
        SUM(CASE WHEN status = 'called' THEN 1 ELSE 0 END) as called_count,
        SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed_count
    ")
    ->whereDate('registration_time', $today)
    ->first();

    // Ambil antrean dipanggil terbaru global
    $globalCurrentCall = Queue::with(['patient', 'poli'])
        ->whereDate('registration_time', $today)
        ->where('status', 'called')
        ->orderByDesc('called_time')
        ->first();

    // Statistik per poli
    $polis = Poli::withCount([
        'queues as waiting_count' => function ($q) use ($today) {
            $q->whereDate('registration_time', $today)->where('status', 'waiting');
        },
        'queues as completed_count' => function ($q) use ($today) {
            $q->whereDate('registration_time', $today)->where('status', 'completed');
        },
        'queues as called_count' => function ($q) use ($today) {
            $q->whereDate('registration_time', $today)->where('status', 'called');
        },
    ])->get();

    // Ambil current queue & patient per poli (yang terakhir dipanggil)
    $currentCallsPerPoli = Queue::with('patient')
        ->whereDate('registration_time', $today)
        ->where('status', 'called')
        ->orderByDesc('called_time')
        ->get()
        ->groupBy('poli_id')
        ->map(function($queues) {
            return $queues->first();
        });

    $polisData = $polis->map(function($poli) use ($currentCallsPerPoli) {
        $currentCall = $currentCallsPerPoli->get($poli->id);

        return [
            'id' => $poli->id,
            'name' => $poli->name,
            'current_queue' => $currentCall->queue_number ?? null,
            'current_patient' => $currentCall->patient->name ?? null,
            'waiting_count' => $poli->waiting_count,
            'completed_count' => $poli->completed_count,
        ];
    });

    return [
        'polis' => $polisData,
        'global_stats' => [
            'total_patients' => $globalStats->total_patients,
            'waiting_count' => $globalStats->waiting_count,
            'called_count' => $globalStats->called_count,
            'completed_count' => $globalStats->completed_count,
        ],
        'global_current_call' => $globalCurrentCall ? [
            'queue_number' => $globalCurrentCall->queue_number,
            'patient_name' => $globalCurrentCall->patient->name,
            'poli_name' => $globalCurrentCall->poli->name,
        ] : null,
    ];
}
}
