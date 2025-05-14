<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $queues = Queue::with(['poli', 'patient'])
            ->whereDate('registration_time', $today)
            ->get();

        $polis = $queues->groupBy('poli_id')->map(function ($items, $poliId) {
            $poliName = $items->first()->poli->name ?? '-';
            $currentQueue = $items->where('status', 'called')->sortByDesc('called_time')->first();

            return [
                'id' => $poliId,
                'name' => $poliName,
                'current_queue' => $currentQueue->queue_number ?? null,
                'current_patient' => $currentQueue->patient->name ?? null,
                'waiting_count' => $items->where('status', 'waiting')->count(),
                'completed_count' => $items->where('status', 'completed')->count(),
            ];
        })->values();

        return view('public.dashboard', ['queues' => $queues, 'polis' => $polis]);
    }

    public function getQueueStatus()
    {
        $today = Carbon::today();

        $queues = Queue::with(['poli', 'patient'])
            ->whereDate('registration_time', $today)
            ->get();

        $data = $queues->groupBy('poli_id')->map(function ($items, $poliId) {
            $poliName = $items->first()->poli->name ?? '-';
            $currentQueue = $items->where('status', 'called')->sortByDesc('called_time')->first();

            return [
                'id' => $poliId,
                'name' => $poliName,
                'current_queue' => $currentQueue->queue_number ?? null,
                'current_patient' => $currentQueue->patient->name ?? null,
                'waiting_count' => $items->where('status', 'waiting')->count(),
                'completed_count' => $items->where('status', 'completed')->count(),
                'last_updated' => now()->toDateTimeString() // Tambahkan timestamp
            ];
        })->values();

    $response = response()->json($data);

    return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                   ->header('Pragma', 'no-cache')
                   ->header('Expires', '0');
    }
}
