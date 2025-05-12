<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Membuat admin dengan role 'admin'
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // Gantilah dengan password yang lebih aman
            'role' => 'admin', // Role admin
            'poli_id' => null, // Bisa disesuaikan jika ada poli terkait
        ]);
    }
}
