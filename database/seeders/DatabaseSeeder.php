<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('waste_types')->insert([
            ['name' => 'Plastik', 'co2_factor' => 2.0, 'reward_per_kg' => 200, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kertas', 'co2_factor' => 1.0, 'reward_per_kg' => 150, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Organik', 'co2_factor' => 0.5, 'reward_per_kg' => 50, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kaca', 'co2_factor' => 0.8, 'reward_per_kg' => 100, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Logam', 'co2_factor' => 3.0, 'reward_per_kg' => 500, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('users')->insert([
           [
            'name' => 'Muhammad Ikhwan',
            'email' => 'ikhwan@ecocycle.id',
            'password' => Hash::make('123456789'),
            'role' => 'warga',
            'rw_name' => 'RW 05',
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
                'name' => 'admin',
                'email' => 'admin@ecocycle.id',
                'password' => Hash::make('123456789'),
                'role' => 'admin',
                'rw_name' => 'RW 05',
                'created_at' => now(),
                'updated_at' => now()  
            ],
            [
                'name' => 'Bank Sampah Maju Jaya',
                'email' => 'majujaya@ecocycle.id',
                'password' => Hash::make('123456789'),
                'role' => 'mitra',
                'rw_name' => 'RW 05',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        DB::table('banks')->insert([
            [
                'name' => 'Bank Sampah Maju Jaya',
                'address' => 'Jl. Kenanga No. 12, RT 03 RW 05, Kelurahan Merdeka, Kecamatan Sukamaju',
                'latitude' => -6.200000,
                'longitude' => 106.816666,
                'operation_hours' => 'Senin - Sabtu, 08:00 - 16:00 WIB',
                'contact' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
                'user_id' => 3
            ]
        ]);
    }
}