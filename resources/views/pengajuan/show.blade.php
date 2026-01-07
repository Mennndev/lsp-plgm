<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan</title>
    
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
                <h2 class="fw-bold">Detail Pengajuan Skema</h2>
                <p class="text-muted mb-0">{{ $pengajuan->program->nama }}</p>
            </div>
            <div>
                <span class="badge bg-{{ $pengajuan->status_badge_color }} fs-6">
                    {{ $pengajuan->status_label }}
                </span>
            </div>
        </div>

        <!-- Info Pengajuan -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2"><strong>Tanggal Pengajuan:</strong> {{ $pengajuan->tanggal_pengajuan->format('d/m/Y H:i') }}</p>
                        <p class="mb-2"><strong>Status:</strong> {{ $pengajuan->status_label }}</p>
                    </div>
                    <div class="col-md-6">
                        @if($pengajuan->tanggal_disetujui)
                        <p class="mb-2"><strong>Tanggal Disetujui:</strong> {{ $pengajuan->tanggal_disetujui->format('d/m/Y H:i') }}</p>
                        @endif
                        @if($pengajuan->approver)
                        <p class="mb-2"><strong>Disetujui oleh:</strong> {{ $pengajuan->approver->nama }}</p>
                        @endif
                    </div>
                </div>
                
                @if($pengajuan->catatan_admin)
                <hr>
                <div class="alert alert-{{ $pengajuan->status == 'rejected' ? 'danger' : 'info' }}">
                    <strong>Catatan Admin:</strong><br>
                    {{ $pengajuan->catatan_admin }}
                </div>
                @endif
            </div>
        </div>

        <!-- Payment Section -->
        @if($pengajuan->status === 'approved' || $pengajuan->status === 'paid')
            @if($pengajuan->pembayaran)
            <div class="card shadow-sm mb-4 border-{{ $pengajuan->pembayaran->status_badge_color }}">
                <div class="card-header bg-{{ $pengajuan->pembayaran->status_badge_color }} text-white">
                    <h5 class="mb-0"><i class="bi bi-credit-card"></i> Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Nominal:</strong> {{ $pengajuan->pembayaran->formatted_nominal }}</p>
                            <p class="mb-2">
                                <strong>Status:</strong> 
                                <span class="badge bg-{{ $pengajuan->pembayaran->status_badge_color }}">
                                    {{ $pengajuan->pembayaran->status_label }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            @if($pengajuan->pembayaran->batas_waktu_bayar)
                            <p class="mb-2">
                                <strong>Batas Waktu:</strong> 
                                {{ $pengajuan->pembayaran->batas_waktu_bayar->format('d/m/Y H:i') }} WIB
                            </p>
                            @endif
                            @if($pengajuan->pembayaran->tanggal_upload)
                            <p class="mb-2">
                                <strong>Tanggal Upload:</strong> 
                                {{ $pengajuan->pembayaran->tanggal_upload->format('d/m/Y H:i') }} WIB
                            </p>
                            @endif
                        </div>
                    </div>
                    @if($pengajuan->pembayaran->catatan_admin)
                    <hr>
                    <div class="alert alert-{{ $pengajuan->pembayaran->status === 'rejected' ? 'danger' : 'info' }} mb-0">
                        <strong>Catatan Admin:</strong><br>
                        {{ $pengajuan->pembayaran->catatan_admin }}
                    </div>
                    @endif
                    <hr>
                    <a href="{{ route('pembayaran.show', $pengajuan->id) }}" class="btn btn-primary">
                        <i class="bi bi-credit-card"></i> 
                        @if($pengajuan->pembayaran->status === 'pending' || $pengajuan->pembayaran->status === 'rejected')
                            Lakukan Pembayaran
                        @else
                            Lihat Detail Pembayaran
                        @endif
                    </a>
                </div>
            </div>
            @endif
        @endif

        <!-- APL-01 Data -->
        @if($pengajuan->apl01)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person-fill"></i> APL-01: Data Pribadi</h5>
            </div>
            <div class="card-body">
                <h6 class="fw-bold mb-3">A. Data Pribadi</h6>
                <div class="row">
                    <div class="col-md-6 mb-2"><strong>Nama Lengkap:</strong> {{ $pengajuan->apl01->nama_lengkap }}</div>
                    <div class="col-md-6 mb-2"><strong>NIK:</strong> {{ $pengajuan->apl01->nik }}</div>
                    <div class="col-md-6 mb-2"><strong>Tempat/Tanggal Lahir:</strong> {{ $pengajuan->apl01->tempat_lahir }}, {{ $pengajuan->apl01->tanggal_lahir->format('d/m/Y') }}</div>
                    <div class="col-md-6 mb-2"><strong>Jenis Kelamin:</strong> {{ $pengajuan->apl01->jenis_kelamin }}</div>
                    <div class="col-md-6 mb-2"><strong>Kebangsaan:</strong> {{ $pengajuan->apl01->kebangsaan }}</div>
                    <div class="col-md-6 mb-2"><strong>Email:</strong> {{ $pengajuan->apl01->email }}</div>
                    <div class="col-md-12 mb-2"><strong>Alamat:</strong> {{ $pengajuan->apl01->alamat_rumah }}</div>
                    @if($pengajuan->apl01->kode_pos)
                    <div class="col-md-6 mb-2"><strong>Kode Pos:</strong> {{ $pengajuan->apl01->kode_pos }}</div>
                    @endif
                </div>

                @if($pengajuan->apl01->kualifikasi_pendidikan)
                <hr>
                <h6 class="fw-bold mb-3">B. Pendidikan & Pekerjaan</h6>
                <div class="row">
                    <div class="col-md-6 mb-2"><strong>Pendidikan:</strong> {{ $pengajuan->apl01->kualifikasi_pendidikan }}</div>
                    @if($pengajuan->apl01->nama_institusi)
                    <div class="col-md-6 mb-2"><strong>Institusi:</strong> {{ $pengajuan->apl01->nama_institusi }}</div>
                    @endif
                    @if($pengajuan->apl01->jabatan)
                    <div class="col-md-6 mb-2"><strong>Jabatan:</strong> {{ $pengajuan->apl01->jabatan }}</div>
                    @endif
                    @if($pengajuan->apl01->alamat_kantor)
                    <div class="col-md-12 mb-2"><strong>Alamat Kantor:</strong> {{ $pengajuan->apl01->alamat_kantor }}</div>
                    @endif
                </div>
                @endif

                @if($pengajuan->apl01->nama_sertifikat)
                <hr>
                <h6 class="fw-bold mb-3">C. Sertifikat</h6>
                <div class="row">
                    <div class="col-md-6 mb-2"><strong>Nama Sertifikat:</strong> {{ $pengajuan->apl01->nama_sertifikat }}</div>
                    @if($pengajuan->apl01->nomor_sertifikat)
                    <div class="col-md-6 mb-2"><strong>Nomor:</strong> {{ $pengajuan->apl01->nomor_sertifikat }}</div>
                    @endif
                </div>
                @endif

                @if($pengajuan->apl01->tujuan_asesmen)
                <hr>
                <h6 class="fw-bold mb-3">Tujuan Asesmen</h6>
                <ul>
                    @foreach($pengajuan->apl01->tujuan_asesmen as $tujuan)
                    <li>{{ $tujuan }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
        @endif

        <!-- APL-02 Data -->
        @if($pengajuan->apl02->count() > 0)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-clipboard-check"></i> APL-02: Self Assessment</h5>
            </div>
            <div class="card-body">
                @foreach($pengajuan->apl02 as $index => $apl02)
                <div class="mb-4">
                    <h6 class="fw-bold">{{ $index + 1 }}. {{ $apl02->unitKompetensi->judul_unit }}</h6>
                    <p class="small text-muted">Kode Unit: {{ $apl02->unitKompetensi->kode_unit }}</p>
                    
                    @if($apl02->self_assessment)
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Elemen</th>
                                    <th width="15%">Status</th>
                                    <th width="20%">Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($apl02->self_assessment as $key => $assessment)
                                <tr>
                                    <td>Elemen {{ $key }}</td>
                                    <td>
                                        <span class="badge bg-{{ $assessment['status'] == 'K' ? 'success' : 'secondary' }}">
                                            {{ $assessment['status'] == 'K' ? 'Kompeten' : 'Belum Kompeten' }}
                                        </span>
                                    </td>
                                    <td>{{ $assessment['bukti'] ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Dokumen -->
        @if($pengajuan->dokumen->count() > 0)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-files"></i> Dokumen Pendukung</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Dokumen</th>
                                <th>Nama File</th>
                                <th>Ukuran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengajuan->dokumen as $index => $dok)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="badge bg-info">{{ strtoupper($dok->jenis_dokumen) }}</span></td>
                                <td>{{ $dok->nama_file }}</td>
                                <td>{{ $dok->formatted_size }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $dok->path) }}" class="btn btn-sm btn-primary" target="_blank">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="d-flex justify-content-between">
            <a href="{{ route('dashboard.user') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
            
            @if($pengajuan->status == 'draft')
            <div>
                <a href="{{ route('pengajuan.create', $pengajuan->program_pelatihan_id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit Draft
                </a>
                <form action="{{ route('pengajuan.destroy', $pengajuan->id) }}" method="POST" class="d-inline" 
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus draft ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>

    <!-- Bootstrap 5 Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
