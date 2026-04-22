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
            ],
            [
                'name' => 'Bank Sampah Berseri',
                'address' => 'Jl. Melati No. 7, RT 01 RW 03, Kelurahan Harapan, Kecamatan Sukamaju',
                'latitude' => -6.210000,
                'longitude' => 106.820000,
                'operation_hours' => 'Senin - Jumat, 09:00 - 15:00 WIB',
                'contact' => '081234567891',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TPS3R RW 08',
                'address' => 'Jl. Anggrek No. 22, RT 04 RW 08, Kelurahan Mandiri, Kecamatan Sukamaju',
                'latitude' => -6.195000,
                'longitude' => 106.810000,
                'operation_hours' => 'Senin - Sabtu, 07:00 - 14:00 WIB',
                'contact' => '081234567892',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bank Sampah Hijau Lestari',
                'address' => 'Jl. Flamboyan No. 5, RT 02 RW 02, Kelurahan Asri, Kecamatan Sukamaju',
                'latitude' => -6.205000,
                'longitude' => 106.825000,
                'operation_hours' => 'Senin - Sabtu, 08:30 - 15:30 WIB',
                'contact' => '081234567893',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bank Sampah Cempaka',
                'address' => 'Jl. Cempaka Putih No. 18, RT 05 RW 07, Kelurahan Damai, Kecamatan Sukamaju',
                'latitude' => -6.215000,
                'longitude' => 106.830000,
                'operation_hours' => 'Selasa - Minggu, 09:00 - 17:00 WIB',
                'contact' => '081234567894',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bank Sampah Digital EcoCycle',
                'address' => 'Kantor Sekretariat RW 05, Jl. Mawar No. 10, Kelurahan Merdeka',
                'latitude' => -6.198000,
                'longitude' => 106.818000,
                'operation_hours' => 'Senin - Sabtu, 10:00 - 14:00 WIB (khusus setoran online)',
                'contact' => '085712345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}