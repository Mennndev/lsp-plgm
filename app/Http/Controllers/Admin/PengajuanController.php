<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSkema;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    private const DEFAULT_PAYMENT_AMOUNT = 500000;
    
    public function index(Request $request)
    {
        $query = PengajuanSkema::with(['user', 'program']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by program
        if ($request->has('program') && $request->program != '') {
            $query->where('program_pelatihan_id', $request->program);
        }

        // Filter by date
        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('tanggal_pengajuan', '>=', $request->tanggal_dari);
        }
        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('tanggal_pengajuan', '<=', $request->tanggal_sampai);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $pengajuanList = $query->orderBy('tanggal_pengajuan', 'desc')
            ->paginate(20);

        return view('admin.pengajuan.index', compact('pengajuanList'));
    }

    public function show($id)
    {
        $pengajuan = PengajuanSkema::with([
            'user', 
            'program.units', 
            'apl01', 
            'apl02.unitKompetensi', 
            'dokumen',
            'approver'
        ])->findOrFail($id);

        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    public function approve($id, Request $request)
    {
        $request->validate([
            'catatan_admin' => 'nullable|string'
        ]);

        $pengajuan = PengajuanSkema::with(['user', 'program'])->findOrFail($id);
        
        $pengajuan->update([
            'status' => 'approved',
            'tanggal_disetujui' => now(),
            'catatan_admin' => $request->catatan_admin,
            'approved_by' => auth()->id(),
        ]);

        // Buat record pembayaran otomatis
        \App\Models\Pembayaran::create([
            'pengajuan_skema_id' => $pengajuan->id,
            'user_id' => $pengajuan->user_id,
            'nominal' => $pengajuan->program->estimasi_biaya ?? self::DEFAULT_PAYMENT_AMOUNT,
            'bank_tujuan' => 'BCA',
            'nomor_rekening' => '1234567890',
            'atas_nama' => 'LSP Politeknik LP3I Global Mandiri',
            'status' => 'pending',
            'batas_waktu_bayar' => now()->addDays(7),
        ]);

        // Kirim notifikasi ke user
        NotificationService::sendPengajuanApproved($pengajuan->user, $pengajuan);

        return redirect()->route('admin.pengajuan.show', $id)
            ->with('success', 'Pengajuan berhasil disetujui dan notifikasi telah dikirim ke user.');
    }

    public function reject($id, Request $request)
    {
        $request->validate([
            'catatan_admin' => 'required|string'
        ], [
            'catatan_admin.required' => 'Catatan admin wajib diisi untuk penolakan.'
        ]);

        $pengajuan = PengajuanSkema::with(['user', 'program'])->findOrFail($id);
        
        $pengajuan->update([
            'status' => 'rejected',
            'catatan_admin' => $request->catatan_admin,
            'approved_by' => auth()->id(),
        ]);

        // Kirim notifikasi ke user
        NotificationService::sendPengajuanRejected($pengajuan->user, $pengajuan, $request->catatan_admin);

        return redirect()->route('admin.pengajuan.show', $id)
            ->with('success', 'Pengajuan berhasil ditolak dan notifikasi telah dikirim ke user.');
    }
}
