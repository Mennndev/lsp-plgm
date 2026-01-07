@extends('layouts.admin')

@section('title', 'Detail Pembayaran - Admin LSP PLGM')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold">Detail Pembayaran #{{ $pembayaran->id }}</h1>
        <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- Info Pembayaran -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-credit-card"></i> Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Status</label>
                        <p>
                            <span class="badge bg-{{ $pembayaran->status_badge_color }} fs-6">
                                {{ $pembayaran->status_label }}
                            </span>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Nominal</label>
                        <h4 class="text-primary">{{ $pembayaran->formatted_nominal }}</h4>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Metode Pembayaran</label>
                        <p class="mb-0">{{ ucfirst(str_replace('_', ' ', $pembayaran->metode_pembayaran)) }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Bank Tujuan</label>
                        <p class="mb-0">{{ $pembayaran->bank_tujuan }} - {{ $pembayaran->nomor_rekening }}</p>
                        <small class="text-muted">a.n {{ $pembayaran->atas_nama }}</small>
                    </div>

                    @if($pembayaran->batas_waktu_bayar)
                    <div class="mb-3">
                        <label class="text-muted small">Batas Waktu Pembayaran</label>
                        <p class="mb-0">{{ $pembayaran->batas_waktu_bayar->format('d F Y, H:i') }} WIB</p>
                        @if($pembayaran->isExpired())
                        <small class="text-danger">
                            <i class="bi bi-exclamation-triangle"></i> Sudah melewati batas waktu
                        </small>
                        @endif
                    </div>
                    @endif

                    @if($pembayaran->tanggal_upload)
                    <div class="mb-3">
                        <label class="text-muted small">Tanggal Upload Bukti</label>
                        <p class="mb-0">{{ $pembayaran->tanggal_upload->format('d F Y, H:i') }} WIB</p>
                    </div>
                    @endif

                    @if($pembayaran->tanggal_verifikasi)
                    <div class="mb-3">
                        <label class="text-muted small">Tanggal Verifikasi</label>
                        <p class="mb-0">{{ $pembayaran->tanggal_verifikasi->format('d F Y, H:i') }} WIB</p>
                    </div>
                    @endif

                    @if($pembayaran->verifier)
                    <div class="mb-3">
                        <label class="text-muted small">Diverifikasi Oleh</label>
                        <p class="mb-0">{{ $pembayaran->verifier->nama ?? $pembayaran->verifier->name }}</p>
                    </div>
                    @endif

                    @if($pembayaran->catatan_admin)
                    <div class="alert alert-{{ $pembayaran->status === 'rejected' ? 'danger' : 'info' }}">
                        <strong>Catatan Admin:</strong><br>
                        {{ $pembayaran->catatan_admin }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Info User & Pengajuan -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-person"></i> Informasi User & Pengajuan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Nama User</label>
                        <p class="mb-0 fw-bold">{{ $pembayaran->user->nama ?? $pembayaran->user->name }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Email</label>
                        <p class="mb-0">{{ $pembayaran->user->email }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Program Sertifikasi</label>
                        <p class="mb-0 fw-bold">{{ $pembayaran->pengajuan->program->nama }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Status Pengajuan</label>
                        <p class="mb-0">
                            <span class="badge bg-{{ $pembayaran->pengajuan->status_badge_color }}">
                                {{ $pembayaran->pengajuan->status_label }}
                            </span>
                        </p>
                    </div>

                    <div class="mb-3">
                        <a href="{{ route('admin.pengajuan.show', $pembayaran->pengajuan_skema_id) }}" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-file-earmark-text"></i> Lihat Detail Pengajuan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bukti Pembayaran -->
    @if($pembayaran->bukti_pembayaran)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-image"></i> Bukti Pembayaran</h5>
        </div>
        <div class="card-body text-center">
            <img src="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}" 
                 alt="Bukti Pembayaran" class="img-fluid rounded" style="max-height: 600px;">
        </div>
    </div>
    @endif

    <!-- Action Buttons -->
    @if($pembayaran->status === 'uploaded')
    <div class="card">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="bi bi-shield-check"></i> Verifikasi Pembayaran</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('admin.pembayaran.verify', $pembayaran->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="catatan_admin" class="form-label">Catatan (Opsional)</label>
                            <textarea name="catatan_admin" id="catatan_admin" class="form-control" rows="3" 
                                      placeholder="Masukkan catatan jika diperlukan"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success" 
                                onclick="return confirm('Yakin ingin memverifikasi pembayaran ini?')">
                            <i class="bi bi-check-circle"></i> Verifikasi Pembayaran
                        </button>
                    </form>
                </div>

                <div class="col-md-6">
                    <form action="{{ route('admin.pembayaran.reject', $pembayaran->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="catatan_admin_reject" class="form-label">
                                Alasan Penolakan <span class="text-danger">*</span>
                            </label>
                            <textarea name="catatan_admin" id="catatan_admin_reject" class="form-control @error('catatan_admin') is-invalid @enderror" 
                                      rows="3" placeholder="Jelaskan alasan penolakan" required></textarea>
                            @error('catatan_admin')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Yakin ingin menolak pembayaran ini?')">
                            <i class="bi bi-x-circle"></i> Tolak Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
