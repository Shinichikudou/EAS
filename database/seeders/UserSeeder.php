<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Admin Sistem
        User::create([
            'name' => 'Admin Sistem',
            'email' => 'adminsistem@gmail.com',
            'password' => Hash::make('admin12345'),
            'role' => 'admin_sistem',
        ]);

        User::create([
            'name' => 'Security',
            'email' => 'security@gmail.com',
            'password' => Hash::make('security12345'),
            'role' => 'security',
        ]);
    }
}
