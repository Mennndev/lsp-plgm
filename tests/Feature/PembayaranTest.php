<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\PengajuanSkema;
use App\Models\ProgramPelatihan;
use App\Models\Pembayaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PembayaranTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that payment record is created when pengajuan is approved
     */
    public function test_payment_created_when_pengajuan_approved(): void
    {
        Storage::fake('public');
        
        // Create an admin user
        $admin = User::factory()->create([
            'nama' => 'Admin User',
            'email' => 'admin@test.com',
            'role' => 'admin'
        ]);

        // Create a regular user
        $user = User::factory()->create([
            'nama' => 'Test User'
        ]);

        // Create a program
        $program = ProgramPelatihan::create([
            'kode_skema' => 'TEST-001',
            'nama' => 'Test Program',
            'slug' => 'test-program',
            'kategori' => 'Test',
            'kategori_slug' => 'test',
            'estimasi_biaya' => 750000,
            'is_published' => 1
        ]);

        // Create a pengajuan skema
        $pengajuan = PengajuanSkema::create([
            'user_id' => $user->id,
            'program_pelatihan_id' => $program->id,
            'status' => 'pending',
            'tanggal_pengajuan' => now(),
        ]);

        // Approve the pengajuan as admin
        $response = $this->actingAs($admin)
            ->post(route('admin.pengajuan.approve', $pengajuan->id), [
                'catatan_admin' => 'Approved for testing'
            ]);

        // Assert redirect
        $response->assertRedirect();

        // Assert pengajuan status is approved
        $pengajuan->refresh();
        $this->assertEquals('approved', $pengajuan->status);

        // Assert payment record was created
        $this->assertDatabaseHas('pembayaran', [
            'pengajuan_skema_id' => $pengajuan->id,
            'user_id' => $user->id,
            'nominal' => '750000.00',
            'status' => 'pending'
        ]);

        // Verify payment relationship
        $this->assertNotNull($pengajuan->pembayaran);
        $this->assertEquals('pending', $pengajuan->pembayaran->status);
    }

    /**
     * Test that user can view payment page
     */
    public function test_user_can_view_payment_page(): void
    {
        // Create a user
        $user = User::factory()->create([
            'nama' => 'Test User'
        ]);

        // Create a program
        $program = ProgramPelatihan::create([
            'kode_skema' => 'TEST-001',
            'nama' => 'Test Program',
            'slug' => 'test-program',
            'kategori' => 'Test',
            'kategori_slug' => 'test',
            'estimasi_biaya' => 500000,
            'is_published' => 1
        ]);

        // Create an approved pengajuan
        $pengajuan = PengajuanSkema::create([
            'user_id' => $user->id,
            'program_pelatihan_id' => $program->id,
            'status' => 'approved',
            'tanggal_pengajuan' => now(),
        ]);

        // Create payment record
        $pembayaran = Pembayaran::create([
            'pengajuan_skema_id' => $pengajuan->id,
            'user_id' => $user->id,
            'nominal' => 500000,
            'bank_tujuan' => 'BCA',
            'nomor_rekening' => '1234567890',
            'atas_nama' => 'LSP Test',
            'status' => 'pending',
        ]);

        // User views payment page
        $response = $this->actingAs($user)
            ->get(route('pembayaran.show', $pengajuan->id));

        // Assert page loads successfully
        $response->assertStatus(200);
        $response->assertViewHas('pengajuan');
        $response->assertViewHas('pembayaran');
        $response->assertViewHas('infoRekening');
    }

    /**
     * Test that user can upload payment proof
     */
    public function test_user_can_upload_payment_proof(): void
    {
        Storage::fake('public');
        
        // Create a user
        $user = User::factory()->create([
            'nama' => 'Test User'
        ]);

        // Create a program
        $program = ProgramPelatihan::create([
            'kode_skema' => 'TEST-001',
            'nama' => 'Test Program',
            'slug' => 'test-program',
            'kategori' => 'Test',
            'kategori_slug' => 'test',
            'estimasi_biaya' => 500000,
            'is_published' => 1
        ]);

        // Create an approved pengajuan
        $pengajuan = PengajuanSkema::create([
            'user_id' => $user->id,
            'program_pelatihan_id' => $program->id,
            'status' => 'approved',
            'tanggal_pengajuan' => now(),
        ]);

        // Create payment record
        $pembayaran = Pembayaran::create([
            'pengajuan_skema_id' => $pengajuan->id,
            'user_id' => $user->id,
            'nominal' => 500000,
            'status' => 'pending',
        ]);

        // Create fake image
        $file = UploadedFile::fake()->image('bukti.jpg');

        // Upload payment proof
        $response = $this->actingAs($user)
            ->post(route('pembayaran.upload', $pengajuan->id), [
                'bukti_pembayaran' => $file
            ]);

        // Assert redirect back
        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Assert payment status changed to uploaded
        $pembayaran->refresh();
        $this->assertEquals('uploaded', $pembayaran->status);
        $this->assertNotNull($pembayaran->bukti_pembayaran);
        $this->assertNotNull($pembayaran->tanggal_upload);

        // Assert file was stored
        Storage::disk('public')->assertExists($pembayaran->bukti_pembayaran);
    }

    /**
     * Test that admin can verify payment
     */
    public function test_admin_can_verify_payment(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'nama' => 'Admin User',
            'email' => 'admin@test.com',
            'role' => 'admin'
        ]);

        // Create a regular user
        $user = User::factory()->create([
            'nama' => 'Test User'
        ]);

        // Create a program
        $program = ProgramPelatihan::create([
            'kode_skema' => 'TEST-001',
            'nama' => 'Test Program',
            'slug' => 'test-program',
            'kategori' => 'Test',
            'kategori_slug' => 'test',
            'estimasi_biaya' => 500000,
            'is_published' => 1
        ]);

        // Create an approved pengajuan
        $pengajuan = PengajuanSkema::create([
            'user_id' => $user->id,
            'program_pelatihan_id' => $program->id,
            'status' => 'approved',
            'tanggal_pengajuan' => now(),
        ]);

        // Create payment with uploaded status
        $pembayaran = Pembayaran::create([
            'pengajuan_skema_id' => $pengajuan->id,
            'user_id' => $user->id,
            'nominal' => 500000,
            'status' => 'uploaded',
            'bukti_pembayaran' => 'bukti-pembayaran/test.jpg',
            'tanggal_upload' => now(),
        ]);

        // Admin verifies payment
        $response = $this->actingAs($admin)
            ->post(route('admin.pembayaran.verify', $pembayaran->id), [
                'catatan_admin' => 'Payment verified'
            ]);

        // Assert redirect
        $response->assertRedirect(route('admin.pembayaran.index'));
        $response->assertSessionHas('success');

        // Assert payment status changed to verified
        $pembayaran->refresh();
        $this->assertEquals('verified', $pembayaran->status);
        $this->assertNotNull($pembayaran->tanggal_verifikasi);
        $this->assertEquals($admin->id, $pembayaran->verified_by);

        // Pengajuan status should remain approved
        $pengajuan->refresh();
        $this->assertEquals('approved', $pengajuan->status);
    }

    /**
     * Test that admin can reject payment
     */
    public function test_admin_can_reject_payment(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'nama' => 'Admin User',
            'email' => 'admin@test.com',
            'role' => 'admin'
        ]);

        // Create a regular user
        $user = User::factory()->create([
            'nama' => 'Test User'
        ]);

        // Create a program
        $program = ProgramPelatihan::create([
            'kode_skema' => 'TEST-001',
            'nama' => 'Test Program',
            'slug' => 'test-program',
            'kategori' => 'Test',
            'kategori_slug' => 'test',
            'estimasi_biaya' => 500000,
            'is_published' => 1
        ]);

        // Create an approved pengajuan
        $pengajuan = PengajuanSkema::create([
            'user_id' => $user->id,
            'program_pelatihan_id' => $program->id,
            'status' => 'approved',
            'tanggal_pengajuan' => now(),
        ]);

        // Create payment with uploaded status
        $pembayaran = Pembayaran::create([
            'pengajuan_skema_id' => $pengajuan->id,
            'user_id' => $user->id,
            'nominal' => 500000,
            'status' => 'uploaded',
            'bukti_pembayaran' => 'bukti-pembayaran/test.jpg',
            'tanggal_upload' => now(),
        ]);

        // Admin rejects payment
        $response = $this->actingAs($admin)
            ->post(route('admin.pembayaran.reject', $pembayaran->id), [
                'catatan_admin' => 'Invalid proof of payment'
            ]);

        // Assert redirect
        $response->assertRedirect(route('admin.pembayaran.index'));
        $response->assertSessionHas('success');

        // Assert payment status changed to rejected
        $pembayaran->refresh();
        $this->assertEquals('rejected', $pembayaran->status);
        $this->assertEquals('Invalid proof of payment', $pembayaran->catatan_admin);
        $this->assertEquals($admin->id, $pembayaran->verified_by);

    }
}
