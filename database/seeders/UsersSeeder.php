<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'User',
            'username' => 'user',
            'password' => Hash::make('user'),
        ]);
        $user->assignRole('user');

        $user = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('admin');

        $user = User::create([
            'name' => 'Kepala GOR',
            'username' => 'kepalagor',
            'password' => Hash::make('kepalagor'),
        ]);
        $user->assignRole('kepala gor');

        $user = User::create([
            'name' => 'Pegawai',
            'username' => 'pegawai',
            'password' => Hash::make('pegawai'),
        ]);
        $user->assignRole('pegawai');
    }
}
