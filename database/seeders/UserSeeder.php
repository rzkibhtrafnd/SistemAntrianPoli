<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Poli;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Klinik',
            'email' => 'admin@klinik.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'poli_id' => null
        ]);

        $poliUmum = Poli::where('name', 'Umum')->first();

        User::create([
            'name' => 'Staff Poli Umum',
            'email' => 'staff@klinik.test',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'poli_id' => $poliUmum->id
        ]);
    }
}
