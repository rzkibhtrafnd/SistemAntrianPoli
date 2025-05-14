<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'specialization', 'poli_id', 'status', 'schedule'];

    protected $casts = [
        'schedule' => 'array',
    ];

    public function getAvailableTimesAttribute()
    {
        $now = now()->timezone('Asia/Jakarta');
        $schedule = $this->schedule;

        if (!$schedule) return [];

        $currentDay = strtolower($now->isoFormat('dddd'));
        if (!in_array($currentDay, $schedule['days'])) {
            return [];
        }

        $start = Carbon::createFromFormat('H:i', $schedule['start_time']);
        $end = Carbon::createFromFormat('H:i', $schedule['end_time']);
        $interval = $schedule['interval'] ?? 15;

        $times = [];
        $current = $start->copy();

        while ($current <= $end) {
            if ($current->gt($now)) {
                $times[] = $current->format('H:i');
            }
            $current->addMinutes($interval);
        }

        return $times;
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }
}
