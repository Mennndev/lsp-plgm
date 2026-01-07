<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\PengajuanSkema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function show($pengajuanId)
    {
        $pengajuan = PengajuanSkema::with(['program', 'pembayaran'])
            ->where('user_id', Auth::id())
            ->findOrFail($pengajuanId);

        if ($pengajuan->status !== 'approved' && $pengajuan->status !== 'paid') {
            return redirect()->route('pengajuan.show', $pengajuanId)
                ->with('error', 'Pengajuan belum disetujui.');
        }

        $pembayaran = $pengajuan->pembayaran;

        $infoRekening = [
            'bank' => 'Bank BCA',
            'nomor' => '1234567890',
            'atas_nama' => 'LSP Politeknik LP3I Global Mandiri',
        ];

        return view('pembayaran.show', compact('pengajuan', 'pembayaran', 'infoRekening'));
    }

    public function upload(Request $request, $pengajuanId)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pengajuan = PengajuanSkema::where('user_id', Auth::id())->findOrFail($pengajuanId);
        $pembayaran = $pengajuan->pembayaran;

        if (!$pembayaran) {
            return back()->with('error', 'Data pembayaran tidak ditemukan.');
        }

        if ($pembayaran->status === 'verified') {
            return back()->with('error', 'Pembayaran sudah terverifikasi.');
        }

        $file = $request->file('bukti_pembayaran');
        $filename = 'bukti_' . $pengajuanId . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('bukti-pembayaran', $filename, 'public');

        $pembayaran->update([
            'bukti_pembayaran' => $path,
            'tanggal_upload' => now(),
            'status' => 'uploaded',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Mohon tunggu verifikasi dari admin.');
    }
}
