<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - {{ $pengajuan->program->nama }}</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/pengajuan.css') }}">
</head>
<body>
    <div class="container py-5">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">Pembayaran Sertifikasi</h2>
                <p class="text-muted mb-0">{{ $pengajuan->program->nama }}</p>
            </div>
            <a href="{{ route('pengajuan.show', $pengajuan->id) }}" class="btn btn-outline-secondary">
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
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-credit-card"></i> Informasi Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted small">Nominal Pembayaran</label>
                            <h3 class="text-primary">{{ $pembayaran->formatted_nominal }}</h3>
                        </div>
                        
                        <div class="mb-3">
                            <label class="text-muted small">Status</label>
                            <p>
                                <span class="badge bg-{{ $pembayaran->status_badge_color }} fs-6">
                                    {{ $pembayaran->status_label }}
                                </span>
                            </p>
                        </div>

                        @if($pembayaran->batas_waktu_bayar)
                        <div class="mb-3">
                            <label class="text-muted small">Batas Waktu Pembayaran</label>
                            <p class="mb-0">
                                <i class="bi bi-calendar-event"></i> 
                                {{ $pembayaran->batas_waktu_bayar->format('d F Y, H:i') }} WIB
                            </p>
                            @if($pembayaran->isExpired())
                            <small class="text-danger">
                                <i class="bi bi-exclamation-triangle"></i> Pembayaran sudah melewati batas waktu
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

                        @if($pembayaran->catatan_admin)
                        <div class="alert alert-{{ $pembayaran->status === 'rejected' ? 'danger' : 'info' }}">
                            <strong>Catatan Admin:</strong><br>
                            {{ $pembayaran->catatan_admin }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Info Rekening -->
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-bank"></i> Informasi Rekening Transfer</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted small">Bank</label>
                            <p class="mb-0 fw-bold">{{ $infoRekening['bank'] }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="text-muted small">Nomor Rekening</label>
                            <p class="mb-0 fw-bold fs-4">{{ $infoRekening['nomor'] }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="text-muted small">Atas Nama</label>
                            <p class="mb-0 fw-bold">{{ $infoRekening['atas_nama'] }}</p>
                        </div>

                        <div class="alert alert-warning">
                            <i class="bi bi-info-circle"></i> 
                            <strong>Petunjuk:</strong>
                            <ol class="mb-0 mt-2 ps-3">
                                <li>Transfer sesuai nominal yang tertera</li>
                                <li>Simpan bukti transfer</li>
                                <li>Upload bukti transfer di bawah ini</li>
                                <li>Tunggu verifikasi dari admin</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload Bukti Pembayaran -->
        @if($pembayaran->status === 'pending' || $pembayaran->status === 'rejected')
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-upload"></i> Upload Bukti Pembayaran</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pembayaran.upload', $pengajuan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="bukti_pembayaran" class="form-label">
                            Pilih File Bukti Transfer (JPG, JPEG, PNG - Max 2MB)
                        </label>
                        <input type="file" class="form-control @error('bukti_pembayaran') is-invalid @enderror" 
                               id="bukti_pembayaran" name="bukti_pembayaran" accept="image/jpeg,image/jpg,image/png" required>
                        @error('bukti_pembayaran')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-upload"></i> Upload Bukti Pembayaran
                    </button>
                </form>
            </div>
        </div>
        @endif

        <!-- Bukti Pembayaran yang Sudah Diupload -->
        @if($pembayaran->bukti_pembayaran)
        <div class="card shadow-sm mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-image"></i> Bukti Pembayaran</h5>
            </div>
            <div class="card-body">
                <img src="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}" 
                     alt="Bukti Pembayaran" class="img-fluid rounded" style="max-height: 500px;">
                
                @if($pembayaran->status === 'uploaded')
                <div class="alert alert-info mt-3">
                    <i class="bi bi-clock-history"></i> 
                    Bukti pembayaran Anda sedang menunggu verifikasi dari admin.
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Bootstrap 5 Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
