<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $polis = Poli::where('status', 'active')->get();
        return view('public.dashboard', compact('polis'));
    }

    public function getQueueStatus()
    {
        $today = date('Y-m-d');

        $queueStatus = Poli::where('status', 'active')
            ->with(['queues' => function($query) use ($today) {
                $query->whereDate('created_at', $today);
            }])
            ->get()
            ->map(function($poli) {
                $waiting = $poli->queues->where('status', 'waiting')->count();
                $called = $poli->queues->where('status', 'called')->first();
                $completed = $poli->queues->where('status', 'completed')->count();

                return [
                    'id' => $poli->id,
                    'name' => $poli->name,
                    'waiting_count' => $waiting,
                    'current_queue' => $called ? $called->queue_number : null,
                    'current_patient' => $called ? $called->patient->name : null,
                    'completed_count' => $completed,
                ];
            });

        return response()->json($queueStatus);
    }

    public function getStatistics()
    {
        $today = date('Y-m-d');

        $statistics = [
            'total_patients' => Queue::whereDate('created_at', $today)->count(),
            'completed' => Queue::whereDate('created_at', $today)->where('status', 'completed')->count(),
            'waiting' => Queue::whereDate('created_at', $today)->where('status', 'waiting')->count(),
            'called' => Queue::whereDate('created_at', $today)->where('status', 'called')->count(),
            'average_wait_time' => $this->calculateAverageWaitTime(),
        ];

        return response()->json($statistics);
    }

    private function calculateAverageWaitTime()
    {
        $today = date('Y-m-d');

        $avgTime = Queue::whereDate('created_at', $today)
            ->whereNotNull('called_time')
            ->whereNotNull('registration_time')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(MINUTE, registration_time, called_time)) as avg_wait_time'))
            ->first();

        return $avgTime->avg_wait_time ?? 0;
    }
}
