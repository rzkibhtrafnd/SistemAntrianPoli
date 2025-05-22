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

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }

    public function getAvailableTimesAttribute()
{
    $schedule = $this->schedule;
    if (!$schedule || empty($schedule)) {
        return [];
    }

    $today = now()->format('l'); // e.g. "Monday"
    $times = [];

    // Cek jika format schedule baru (dengan hari sebagai key)
    if (isset($schedule[$today])) {
        $timeSlots = $schedule[$today];
        if (is_array($timeSlots) && count($timeSlots) >= 2) {
            $start = Carbon::createFromFormat('H:i', $timeSlots[0]);
            $end = Carbon::createFromFormat('H:i', $timeSlots[1]);

            $interval = 15; // menit
            $current = $start->copy();

            while ($current->lt($end)) {
                $times[] = $current->format('H:i');
                $current->addMinutes($interval);
            }
        }
    }

    return $times;
}
}
