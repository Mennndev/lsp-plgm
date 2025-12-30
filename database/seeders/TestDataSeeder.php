<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test user
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'user@test.com'],
            [
                'nama' => 'Test User',
                'password' => bcrypt('password'),
                'no_hp' => '081234567890',
                'role' => 'user',
            ]
        );

        // Create a test program
        $program = \App\Models\ProgramPelatihan::firstOrCreate(
            ['slug' => 'teknisi-komputer-junior'],
            [
                'kode_skema' => 'TKJ-001',
                'nama' => 'Teknisi Komputer Junior',
                'kategori' => 'Teknologi Informasi',
                'kategori_slug' => 'teknologi-informasi',
                'deskripsi_singkat' => 'Program sertifikasi untuk teknisi komputer tingkat junior',
                'jumlah_unit' => 5,
                'estimasi_biaya' => 1500000,
                'is_published' => true,
            ]
        );

        // Create a test pengajuan
        $pengajuan = \App\Models\PengajuanSkema::firstOrCreate(
            [
                'user_id' => $user->id,
                'program_pelatihan_id' => $program->id,
            ],
            [
                'status' => 'pending',
                'tanggal_pengajuan' => now(),
            ]
        );

        echo "Test data created:\n";
        echo "- User: {$user->email} (password: password)\n";
        echo "- Program: {$program->nama}\n";
        echo "- Pengajuan ID: {$pengajuan->id}\n";
    }
}
