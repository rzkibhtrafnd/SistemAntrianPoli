<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        Patient::factory()->count(10)->create();

        // atau manual
        Patient::create([
            'registration_number' => 'REG-' . Str::upper(Str::random(6)),
            'name' => 'Budi Santoso',
            'gender' => 'Laki-laki',
            'birth_date' => '1990-05-12',
            'address' => 'Jl. Merdeka No.10',
            'phone' => '081234567890',
            'medical_record' => 'Tidak ada alergi'
        ]);
    }
}
