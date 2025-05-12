<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = ['registration_number', 'name', 'gender', 'birth_date','address', 'phone', 'medical_record'];

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }
}
