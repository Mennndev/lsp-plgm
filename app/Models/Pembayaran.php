<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    
    protected $fillable = [
        'pengajuan_skema_id',
        'user_id',
        'nominal',
        'metode_pembayaran',
        'bank_tujuan',
        'nomor_rekening',
        'atas_nama',
        'bukti_pembayaran',
        'tanggal_upload',
        'tanggal_verifikasi',
        'status',
        'catatan_admin',
        'verified_by',
        'batas_waktu_bayar',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
        'tanggal_upload' => 'datetime',
        'tanggal_verifikasi' => 'datetime',
        'batas_waktu_bayar' => 'datetime',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanSkema::class, 'pengajuan_skema_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'uploaded' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak',
            default => $this->status,
        };
    }

    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'uploaded' => 'info',
            'verified' => 'success',
            'rejected' => 'danger',
            default => 'secondary',
        };
    }

    public function isExpired()
    {
        return $this->batas_waktu_bayar && now()->gt($this->batas_waktu_bayar) && $this->status === 'pending';
    }

    public function getFormattedNominalAttribute()
    {
        return 'Rp ' . number_format($this->nominal, 0, ',', '.');
    }
}
