<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\PengajuanSkema;
use App\Models\ProgramPelatihan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that admin dashboard view has pengajuanTerbaru variable
     */
    public function test_admin_dashboard_has_pengajuan_terbaru_variable(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'role' => 'admin'
        ]);

        // Act as admin and visit dashboard
        $response = $this->actingAs($admin)
            ->get(route('admin.dashboard'));

        // Assert the page loads successfully
        $response->assertStatus(200);

        // Assert the view receives pengajuanTerbaru variable (not pendaftaranBaru)
        $response->assertViewHas('pengajuanTerbaru');
        $response->assertViewMissing('pendaftaranBaru');
    }

    /**
     * Test that dashboard controller uses PengajuanSkema model
     */
    public function test_dashboard_displays_pengajuan_skema_data(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        // Create a regular user
        $user = User::factory()->create([
            'name' => 'Test User'
        ]);

        // Create a program manually (since factory is empty)
        $program = ProgramPelatihan::create([
            'kode_skema' => 'TEST-001',
            'nama' => 'Test Program',
            'slug' => 'test-program',
            'kategori' => 'Test',
            'is_published' => 1
        ]);

        // Create a pengajuan skema
        $pengajuan = PengajuanSkema::create([
            'user_id' => $user->id,
            'program_pelatihan_id' => $program->id,
            'status' => 'pending',
            'tanggal_pengajuan' => now(),
        ]);

        // Act as admin and visit dashboard
        $response = $this->actingAs($admin)
            ->get(route('admin.dashboard'));

        // Assert the page loads successfully
        $response->assertStatus(200);

        // Assert the view receives pengajuanTerbaru with data
        $pengajuanTerbaru = $response->viewData('pengajuanTerbaru');
        $this->assertNotEmpty($pengajuanTerbaru);
        
        // Verify it's the correct pengajuan
        $firstPengajuan = $pengajuanTerbaru->first();
        $this->assertEquals($pengajuan->id, $firstPengajuan->id);
        
        // Verify relations are loaded
        $this->assertNotNull($firstPengajuan->user);
        $this->assertNotNull($firstPengajuan->program);
        $this->assertEquals('Test User', $firstPengajuan->user->name);
        $this->assertEquals('Test Program', $firstPengajuan->program->nama);
    }
}
