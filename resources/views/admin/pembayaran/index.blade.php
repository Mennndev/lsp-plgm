@extends('layouts.admin')

@section('title', 'Pembayaran - Admin LSP PLGM')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold">Manajemen Pembayaran</h1>
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

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.pembayaran.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Status Pembayaran</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                        <option value="uploaded" {{ request('status') === 'uploaded' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Pembayaran -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama User</th>
                            <th>Program</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Tanggal Upload</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembayaranList as $pembayaran)
                        <tr>
                            <td>{{ $pembayaran->id }}</td>
                            <td>{{ $pembayaran->user->nama ?? $pembayaran->user->name }}</td>
                            <td>{{ $pembayaran->pengajuan->program->nama }}</td>
                            <td class="fw-bold">{{ $pembayaran->formatted_nominal }}</td>
                            <td>
                                <span class="badge bg-{{ $pembayaran->status_badge_color }}">
                                    {{ $pembayaran->status_label }}
                                </span>
                            </td>
                            <td>
                                @if($pembayaran->tanggal_upload)
                                    {{ $pembayaran->tanggal_upload->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.pembayaran.show', $pembayaran->id) }}" 
                                   class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                <p class="text-muted mt-2">Tidak ada data pembayaran</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($pembayaranList->hasPages())
            <div class="mt-3">
                {{ $pembayaranList->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
