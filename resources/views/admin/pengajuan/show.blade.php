@extends('layouts.admin')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pengajuan Skema</h1>
        <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Status & Actions -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Status Pengajuan</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama User:</strong> {{ $pengajuan->user->nama }}</p>
                    <p><strong>Email:</strong> {{ $pengajuan->user->email }}</p>
                    <p><strong>Program:</strong> {{ $pengajuan->program->nama }}</p>
                    <p><strong>Tanggal Pengajuan:</strong> {{ $pengajuan->tanggal_pengajuan->format('d/m/Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <p>
                        <strong>Status:</strong> 
                        <span class="badge bg-{{ $pengajuan->status_badge_color }} fs-6">
                            {{ $pengajuan->status_label }}
                        </span>
                    </p>
                    @if($pengajuan->tanggal_disetujui)
                    <p><strong>Tanggal Diproses:</strong> {{ $pengajuan->tanggal_disetujui->format('d/m/Y H:i') }}</p>
                    @endif
                    @if($pengajuan->approver)
                    <p><strong>Diproses oleh:</strong> {{ $pengajuan->approver->nama }}</p>
                    @endif
                </div>
            </div>

            @if($pengajuan->status == 'pending')
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <h6 class="font-weight-bold mb-3">Tindakan</h6>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                        <i class="bi bi-check-circle"></i> Setujui Pengajuan
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="bi bi-x-circle"></i> Tolak Pengajuan
                    </button>
                </div>
            </div>
            @endif

            @if($pengajuan->catatan_admin)
            <hr>
            <div class="alert alert-{{ $pengajuan->status == 'rejected' ? 'danger' : 'info' }}">
                <strong>Catatan Admin:</strong><br>
                {{ $pengajuan->catatan_admin }}
            </div>
            @endif
        </div>
    </div>

    <!-- APL-01 Data -->
    @if($pengajuan->apl01)
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">APL-01: Data Pribadi</h6>
        </div>
        <div class="card-body">
            <h6 class="font-weight-bold mb-3">A. Data Pribadi</h6>
            <table class="table table-sm table-bordered">
                <tr><th width="25%">Nama Lengkap</th><td>{{ $pengajuan->apl01->nama_lengkap }}</td></tr>
                <tr><th>NIK</th><td>{{ $pengajuan->apl01->nik }}</td></tr>
                <tr><th>Tempat/Tanggal Lahir</th><td>{{ $pengajuan->apl01->tempat_lahir }}, {{ $pengajuan->apl01->tanggal_lahir->format('d/m/Y') }}</td></tr>
                <tr><th>Jenis Kelamin</th><td>{{ $pengajuan->apl01->jenis_kelamin }}</td></tr>
                <tr><th>Kebangsaan</th><td>{{ $pengajuan->apl01->kebangsaan }}</td></tr>
                <tr><th>Alamat</th><td>{{ $pengajuan->apl01->alamat_rumah }}</td></tr>
                <tr><th>Email</th><td>{{ $pengajuan->apl01->email }}</td></tr>
                <tr><th>Telepon</th><td>{{ $pengajuan->apl01->telepon_kantor }}</td></tr>
            </table>

            @if($pengajuan->apl01->kualifikasi_pendidikan)
            <h6 class="font-weight-bold mb-3 mt-4">B. Pendidikan & Pekerjaan</h6>
            <table class="table table-sm table-bordered">
                <tr><th width="25%">Pendidikan</th><td>{{ $pengajuan->apl01->kualifikasi_pendidikan }}</td></tr>
                @if($pengajuan->apl01->nama_institusi)
                <tr><th>Institusi</th><td>{{ $pengajuan->apl01->nama_institusi }}</td></tr>
                @endif
                @if($pengajuan->apl01->jabatan)
                <tr><th>Jabatan</th><td>{{ $pengajuan->apl01->jabatan }}</td></tr>
                @endif
                @if($pengajuan->apl01->alamat_kantor)
                <tr><th>Alamat Kantor</th><td>{{ $pengajuan->apl01->alamat_kantor }}</td></tr>
                @endif
            </table>
            @endif

            @if($pengajuan->apl01->tujuan_asesmen)
            <h6 class="font-weight-bold mb-3 mt-4">Tujuan Asesmen</h6>
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
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">APL-02: Self Assessment</h6>
        </div>
        <div class="card-body">
            @foreach($pengajuan->apl02 as $index => $apl02)
            <div class="mb-4">
                <h6 class="font-weight-bold">{{ $index + 1 }}. {{ $apl02->unitKompetensi->judul_unit }}</h6>
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
            @if(!$loop->last)<hr>@endif
            @endforeach
        </div>
    </div>
    @endif

    <!-- Dokumen -->
    @if($pengajuan->dokumen->count() > 0)
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Dokumen Pendukung</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
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
                                <a href="{{ Storage::url($dok->path) }}" class="btn btn-sm btn-primary" target="_blank">
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
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.pengajuan.approve', $pengajuan->id) }}">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="approveModalLabel">Setujui Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menyetujui pengajuan ini?</p>
                    <div class="mb-3">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" name="catatan_admin" rows="3" placeholder="Tambahkan catatan jika diperlukan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Ya, Setujui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.pengajuan.reject', $pengajuan->id) }}">
                @csrf
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="rejectModalLabel">Tolak Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menolak pengajuan ini?</p>
                    <div class="mb-3">
                        <label class="form-label">Catatan <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="catatan_admin" rows="3" required placeholder="Berikan alasan penolakan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
