<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates comprehensive user data for testing all roles.
     */
    public function run(): void
    {
        $this->command->info('Creating users for all roles...');

        // ==============================
        // ADMIN USERS
        // ==============================
        $this->command->line('');
        $this->command->info('👤 Creating Admin users...');

        DB::table('pengguna')->insertOrIgnore([
            [
                'nama_lengkap' => 'Admin System',
                'email' => 'admin@tanami.com',
                'password' => Hash::make('password'),
                'role_pengguna' => 'admin',
                'alamat' => 'Kantor Pusat Tanami',
                'no_hp' => '081234567890',
                'is_verified' => true,
                'tgl_daftar' => now()->subMonths(6),
                'tgl_update' => now(),
            ],
            [
                'nama_lengkap' => 'Admin Support',
                'email' => 'support@tanami.com',
                'password' => Hash::make('password'),
                'role_pengguna' => 'admin',
                'alamat' => 'Kantor Cabang Jakarta',
                'no_hp' => '081234567891',
                'is_verified' => true,
                'tgl_daftar' => now()->subMonths(3),
                'tgl_update' => now(),
            ],
        ]);
        $this->command->line('  ✓ admin@tanami.com (password)');
        $this->command->line('  ✓ support@tanami.com (password)');

        // ==============================
        // PETANI USERS
        // ==============================
        $this->command->line('');
        $this->command->info('🌾 Creating Petani users...');

        $petaniData = [
            ['Pak Tono', 'tono@petani.com', 'Bogor, Jawa Barat', true, 90],
            ['Bu Siti', 'siti@petani.com', 'Bandung, Jawa Barat', true, 60],
            ['Pak Ahmad', 'ahmad@petani.com', 'Malang, Jawa Timur', true, 45],
            ['Bu Dewi', 'dewi@petani.com', 'Yogyakarta', true, 30],
            ['Pak Joko', 'joko@petani.com', 'Solo, Jawa Tengah', true, 20],
            ['Bu Ratna', 'ratna@petani.com', 'Surabaya, Jawa Timur', false, 10], // Not verified
            ['Pak Udin', 'udin@petani.com', 'Semarang, Jawa Tengah', false, 5],  // Not verified
        ];

        foreach ($petaniData as $data) {
            DB::table('pengguna')->insertOrIgnore([
                'nama_lengkap' => $data[0],
                'email' => $data[1],
                'password' => Hash::make('password'),
                'role_pengguna' => 'petani',
                'alamat' => $data[2],
                'no_hp' => '08' . rand(1000000000, 9999999999),
                'is_verified' => $data[3],
                'tgl_daftar' => now()->subDays($data[4]),
                'tgl_update' => now(),
            ]);
            $status = $data[3] ? '✓' : '○';
            $this->command->line("  {$status} {$data[1]} (password) " . ($data[3] ? '' : '[unverified]'));
        }

        // ==============================
        // PEMBELI USERS
        // ==============================
        $this->command->line('');
        $this->command->info('🛒 Creating Pembeli users...');

        $pembeliData = [
            ['Budi Santoso', 'budi@pembeli.com', 'Jakarta Selatan', true, 100],
            ['Ani Wijaya', 'ani@pembeli.com', 'Tangerang', true, 80],
            ['Dedi Kurniawan', 'dedi@pembeli.com', 'Bekasi', true, 60],
            ['Citra Lestari', 'citra@pembeli.com', 'Depok', true, 45],
            ['Eko Prasetyo', 'eko@pembeli.com', 'Bogor', true, 30],
            ['Fitri Handayani', 'fitri@pembeli.com', 'Jakarta Timur', true, 25],
            ['Gilang Ramadhan', 'gilang@pembeli.com', 'Jakarta Barat', true, 20],
            ['Hana Putri', 'hana@pembeli.com', 'Bandung', true, 15],
            ['Indra Wijaya', 'indra@pembeli.com', 'Surabaya', true, 10],
            ['Jihan Amalia', 'jihan@pembeli.com', 'Yogyakarta', false, 5],  // New unverified
        ];

        foreach ($pembeliData as $data) {
            DB::table('pengguna')->insertOrIgnore([
                'nama_lengkap' => $data[0],
                'email' => $data[1],
                'password' => Hash::make('password'),
                'role_pengguna' => 'pembeli',
                'alamat' => $data[2],
                'no_hp' => '08' . rand(1000000000, 9999999999),
                'is_verified' => $data[3],
                'tgl_daftar' => now()->subDays($data[4]),
                'tgl_update' => now(),
            ]);
            $status = $data[3] ? '✓' : '○';
            $this->command->line("  {$status} {$data[1]} (password) " . ($data[3] ? '' : '[unverified]'));
        }

        $this->command->line('');
        $this->command->info('✅ PenggunaSeeder completed!');
        $this->command->info('   Total: 2 admin, 7 petani, 10 pembeli');
        $this->command->info('   Default password: password');
    }
}
