<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;
    protected $fillable = [
        'queue_number', 'patient_id', 'poli_id', 'doctor_id',
        'status', 'registration_time', 'called_time', 'finish_time', 'notes'
    ];

    protected $dates = [
        'registration_time', 'called_time', 'finish_time'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
