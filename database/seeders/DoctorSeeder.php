<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Poli;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $poliUmum = Poli::where('name', 'Umum')->first();
        $poliGigi = Poli::where('name', 'Gigi')->first();

        // Format default untuk setiap hari
        $defaultSchedule = [
            "Monday"    => [null, null],
            "Tuesday"   => [null, null],
            "Wednesday" => [null, null],
            "Thursday"  => [null, null],
            "Friday"    => [null, null],
            "Saturday"  => [null, null],
            "Sunday"    => [null, null],
        ];

        // Jadwal Dr. Andi (Senin dan Rabu)
        $scheduleAndi = $defaultSchedule;
        $scheduleAndi["Monday"]    = ["08:00", "12:00"];
        $scheduleAndi["Wednesday"] = ["10:00", "14:00"];

        Doctor::create([
            'name' => 'Dr. Andi Wijaya',
            'specialization' => 'Umum',
            'poli_id' => $poliUmum->id,
            'status' => 'active',
            'schedule' => json_encode($scheduleAndi),
        ]);

        // Jadwal Drg. Siti (Selasa dan Kamis)
        $scheduleSiti = $defaultSchedule;
        $scheduleSiti["Tuesday"]  = ["09:00", "13:00"];
        $scheduleSiti["Thursday"] = ["11:00", "15:00"];

        Doctor::create([
            'name' => 'Drg. Siti Nurhaliza',
            'specialization' => 'Gigi',
            'poli_id' => $poliGigi->id,
            'status' => 'active',
            'schedule' => json_encode($scheduleSiti),
        ]);
    }
}
