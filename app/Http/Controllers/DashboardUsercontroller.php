<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\PengajuanSkema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class DashboardUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // TODO: ganti collect() dengan query ke database masing-masing
        // contoh nanti:
        // $asesmenList   = Asesmen::where('user_id', $user->id)->latest()->get();
        // $riwayatList   = RiwayatAsesmen::where('user_id', $user->id)->latest()->get();

        $asesmenList   = collect();  // data untuk tabel "Beranda"
        
        // Fetch user's pengajuan skema
        $pengajuanList = PengajuanSkema::with('program')
            ->where('user_id', $user->id)
            ->latest('tanggal_pengajuan')
            ->get();
        
        $riwayatList   = collect();  // data untuk tabel "Riwayat Asesmen"

        $notificationCount = 0;      // kalau nanti ada notifikasi, isi dari DB

        return view('dashboard.user', compact(
            'user',
            'asesmenList',
            'pengajuanList',
            'riwayatList',
            'notificationCount'
        ));
    }

}
