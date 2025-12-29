<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramPelatihan;
use App\Models\UnitKompetensi;
use App\Models\ElemenKompetensi;
use App\Models\User;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Create test program
        $program = ProgramPelatihan::create([
            'kode_skema' => 'N.821100.053.02',
            'nama' => 'Operator Komputer',
            'slug' => 'operator-komputer',
            'kategori' => 'Teknologi Informasi',
            'kategori_slug' => 'teknologi-informasi',
            'rujukan_skkni' => 'Kepmenaker No. 181 Tahun 2013',
            'jumlah_unit' => 2,
            'estimasi_biaya' => 1500000,
            'mata_uang' => 'IDR',
            'deskripsi_singkat' => 'Program sertifikasi untuk operator komputer',
            'ringkasan' => '<p>Program ini mencakup kompetensi dasar dalam pengoperasian komputer.</p>',
            'persyaratan_peserta' => '<ul><li>Minimal SMA/SMK</li><li>Mampu mengoperasikan komputer</li></ul>',
            'metode_asesmen' => '<p>Tes tertulis dan praktik</p>',
            'is_published' => true,
        ]);

        // Create first unit with elements
        $unit1 = UnitKompetensi::create([
            'program_pelatihan_id' => $program->id,
            'no_urut' => 1,
            'kode_unit' => 'N.821100.053.02',
            'judul_unit' => 'Memproduksi Dokumen di Komputer',
        ]);

        ElemenKompetensi::create([
            'unit_kompetensi_id' => $unit1->id,
            'no_urut' => 1,
            'nama_elemen' => 'Mempersiapkan piranti lunak pengolah kata',
        ]);

        ElemenKompetensi::create([
            'unit_kompetensi_id' => $unit1->id,
            'no_urut' => 2,
            'nama_elemen' => 'Mengenali menu-menu yang terdapat dalam piranti lunak',
        ]);

        ElemenKompetensi::create([
            'unit_kompetensi_id' => $unit1->id,
            'no_urut' => 3,
            'nama_elemen' => 'Membuat dokumen dengan piranti lunak pengolah kata',
        ]);

        // Create second unit with elements
        $unit2 = UnitKompetensi::create([
            'program_pelatihan_id' => $program->id,
            'no_urut' => 2,
            'kode_unit' => 'N.821100.054.02',
            'judul_unit' => 'Mengoperasikan Sistem Operasi',
        ]);

        ElemenKompetensi::create([
            'unit_kompetensi_id' => $unit2->id,
            'no_urut' => 1,
            'nama_elemen' => 'Mempersiapkan sistem operasi',
        ]);

        ElemenKompetensi::create([
            'unit_kompetensi_id' => $unit2->id,
            'no_urut' => 2,
            'nama_elemen' => 'Menjalankan sistem operasi',
        ]);

        ElemenKompetensi::create([
            'unit_kompetensi_id' => $unit2->id,
            'no_urut' => 3,
            'nama_elemen' => 'Menutup sistem operasi',
        ]);
    }
}
