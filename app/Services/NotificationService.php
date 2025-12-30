<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Models\PengajuanSkema;

class NotificationService
{
    public static function send(User $user, string $title, string $message, array $options = [])
    {
        return Notification::create([
            'user_id' => $user->id,
            'title' => $title,
            'message' => $message,
            'type' => $options['type'] ?? 'info',
            'icon' => $options['icon'] ?? 'bi-bell',
            'link' => $options['link'] ?? null,
            'data' => $options['data'] ?? null,
        ]);
    }

    public static function sendPengajuanApproved(User $user, PengajuanSkema $pengajuan)
    {
        return self::send($user, 
            'Pengajuan Disetujui',
            "Selamat! Pengajuan skema sertifikasi \"{$pengajuan->program->nama}\" Anda telah disetujui. Silakan cek email Anda untuk informasi lebih lanjut.",
            [
                'type' => 'success',
                'icon' => 'bi-check-circle-fill',
                'link' => route('pengajuan.show', $pengajuan->id),
                'data' => [
                    'pengajuan_id' => $pengajuan->id,
                    'program_nama' => $pengajuan->program->nama,
                ],
            ]
        );
    }

    public static function sendPengajuanRejected(User $user, PengajuanSkema $pengajuan, ?string $alasan = null)
    {
        $message = "Maaf, pengajuan skema sertifikasi \"{$pengajuan->program->nama}\" Anda ditolak.";
        if ($alasan) {
            $message .= " Alasan: {$alasan}";
        }

        return self::send($user,
            'Pengajuan Ditolak',
            $message,
            [
                'type' => 'danger',
                'icon' => 'bi-x-circle-fill',
                'link' => route('pengajuan.show', $pengajuan->id),
                'data' => [
                    'pengajuan_id' => $pengajuan->id,
                    'program_nama' => $pengajuan->program->nama,
                    'alasan' => $alasan,
                ],
            ]
        );
    }
}
