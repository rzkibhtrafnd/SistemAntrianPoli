<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    public function run(): void
    {
        $polis = [
            ['name' => 'Umum', 'description' => 'Pelayanan umum'],
            ['name' => 'Gigi', 'description' => 'Pelayanan gigi dan mulut'],
            ['name' => 'Anak', 'description' => 'Pelayanan anak-anak'],
        ];

        foreach ($polis as $poli) {
            Poli::create([
                'name' => $poli['name'],
                'description' => $poli['description'],
                'status' => 'active',
            ]);
        }
    }
}
