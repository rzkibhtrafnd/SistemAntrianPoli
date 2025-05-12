<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'status'];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }

    public function staff()
    {
        return $this->hasMany(User::class);
    }
}
