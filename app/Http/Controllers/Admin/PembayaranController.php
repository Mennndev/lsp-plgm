<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with(['user', 'pengajuan.program']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $pembayaranList = $query->orderByRaw("FIELD(status, 'uploaded', 'pending', 'verified', 'rejected')")
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        return view('admin.pembayaran.index', compact('pembayaranList'));
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::with(['user', 'pengajuan.program', 'verifier'])->findOrFail($id);
        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    public function verify(Request $request, $id)
    {
        $pembayaran = Pembayaran::with(['user', 'pengajuan.program'])->findOrFail($id);

        if ($pembayaran->status === 'verified') {
            return back()->with('error', 'Pembayaran sudah terverifikasi.');
        }

        $pembayaran->update([
            'status' => 'verified',
            'tanggal_verifikasi' => now(),
            'catatan_admin' => $request->catatan_admin,
            'verified_by' => auth()->id(),
        ]);

        $pembayaran->pengajuan->update(['status' => 'paid']);

        NotificationService::send(
            $pembayaran->user,
            'Pembayaran Terverifikasi',
            "Pembayaran untuk skema \"{$pembayaran->pengajuan->program->nama}\" telah diverifikasi.",
            ['type' => 'success', 'icon' => 'bi-check-circle-fill', 'link' => route('pengajuan.show', $pembayaran->pengajuan_skema_id)]
        );

        return redirect()->route('admin.pembayaran.index')->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['catatan_admin' => 'required|string']);

        $pembayaran = Pembayaran::with(['user', 'pengajuan.program'])->findOrFail($id);

        $pembayaran->update([
            'status' => 'rejected',
            'catatan_admin' => $request->catatan_admin,
            'verified_by' => auth()->id(),
        ]);

        NotificationService::send(
            $pembayaran->user,
            'Pembayaran Ditolak',
            "Pembayaran ditolak. Alasan: {$request->catatan_admin}",
            ['type' => 'danger', 'icon' => 'bi-x-circle-fill', 'link' => route('pembayaran.show', $pembayaran->pengajuan_skema_id)]
        );

        return redirect()->route('admin.pembayaran.index')->with('success', 'Pembayaran ditolak.');
    }
}
