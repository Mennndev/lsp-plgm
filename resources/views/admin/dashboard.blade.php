{{-- resources/views/admin/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    ...

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
</head>

<body class="admin-body">
<div id="wrapper"><!-- 🔹 HARUS id="wrapper" -->

    {{-- SIDEBAR --}}
    <div id="sidebar-wrapper"><!-- 🔹 HARUS id="sidebar-wrapper" -->
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/logo.png') }}" alt="LSP PLGM">
            </a>
        </div>

        <ul class="sidebar-nav"><!-- 🔹 tambahkan class sidebar-nav -->
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>

            <li class="{{ request()->is('admin/program-pelatihan*') ? 'active' : '' }}">
                <a href="{{ url('admin/program-pelatihan') }}">
                    <i class="bi bi-journal-text"></i> Program Pelatihan
                </a>
            </li>

            <li class="{{ request()->is('admin/asesi*') ? 'active' : '' }}">
                <a href="{{ url('admin/asesi') }}">
                    <i class="bi bi-people"></i> Data Asesi
                </a>
            </li>

            <li class="{{ request()->is('admin/pengguna*') ? 'active' : '' }}">
                <a href="{{ url('admin/pengguna') }}">
                    <i class="bi bi-person-gear"></i> Pengguna & Role
                </a>
            </li>
             <li class="{{ request()->is('admin/pengguna*') ? 'active' : '' }}">
                <a href="{{ url('admin/berita') }}">
                    <i class="bi bi-newspaper"></i> Berita
                </a>
            </li>
        </ul>
    </div>
    {{-- /SIDEBAR --}}

    {{-- KONTEN --}}
    <div id="page-content-wrapper"><!-- 🔹 HARUS id="page-content-wrapper" -->

        <nav class="admin-navbar">
            <div class="nav-title">Panel Admin LSP PLGM</div>
            <div class="admin-user">
                <span class="text-muted d-none d-sm-inline">{{ now()->format('d M Y') }}</span>

                <div class="dropdown">
                    <a class="dropdown-toggle text-decoration-none" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ auth()->user()->name ?? 'Administrator' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-1"></i> Pengaturan Akun</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </a>
                        </li>
                    </ul>
                    <form id="logout-form" class="d-none" method="POST" action="{{ route('logout') }}">
                        @csrf
                    </form>
                </div>
            </div>
        </nav>

       <div class="admin-content">

    {{-- STAT CARD DI ATAS --}}
    <section class="admin-stats">
        <div class="admin-card">
            <div class="info">
                <h6>Program Pelatihan</h6>
                <h3>{{ $totalProgram ?? 0 }}</h3>
                <small class="text-muted">Program aktif yang sudah dipublish</small>
            </div>
            <div class="icon">
                <i class="bi bi-journal-text"></i>
            </div>
        </div>

        <div class="admin-card">
            <div class="info">
                <h6>Unit Kompetensi</h6>
                <h3>{{ $totalUnit ?? 0 }}</h3>
                <small class="text-muted">Unit kompetensi terdaftar</small>
            </div>
            <div class="icon">
                <i class="bi bi-list-check"></i>
            </div>
        </div>

        <div class="admin-card">
            <div class="info">
                <h6>Profesi Terkait</h6>
                <h3>{{ $totalProfesi ?? 0 }}</h3>
                <small class="text-muted">Profesi yang di-mapping ke program</small>
            </div>
            <div class="icon">
                <i class="bi bi-briefcase"></i>
            </div>
        </div>

        <div class="admin-card">
            <div class="info">
                <h6>Asesi Terdaftar</h6>
                <h3>{{ $totalAsesi ?? 0 }}</h3>
                <small class="text-muted">Akun asesi di sistem</small>
            </div>
            <div class="icon">
                <i class="bi bi-people"></i>
            </div>
        </div>
    </section>

    {{-- ROW BAWAH: PROGRAM TERBARU + PENDAFTARAN TERBARU --}}
    <div class="row">
        {{-- PROGRAM PELATIHAN TERBARU --}}
        <div class="col-lg-8 mb-4">
            <div class="admin-table">
                <h5>Program Pelatihan Terbaru</h5>
                <div class="table-responsive">
                    <table>
                        <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Program</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th style="width: 100px;">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($programTerbaru as $program)
                            <tr>
                                <td>{{ $program->kode_skema }}</td>
                                <td>{{ $program->nama }}</td>
                                <td>{{ $program->kategori }}</td>
                                <td>
                                    @if($program->is_published)
                                        <span class="badge bg-success">Publish</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('admin/program-pelatihan/'.$program->id.'/edit') }}"
                                       class="btn-admin btn-primary-admin btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ url('skema/'.$program->slug) }}"
                                       class="btn-admin btn-sm"
                                       style="background:#e5e7eb;"
                                       target="_blank">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Belum ada data program pelatihan.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- PANEL KANAN: PENGAJUAN SKEMA TERBARU + INFO SISTEM --}}
        <div class="col-lg-4 mb-4">
            <div class="admin-table mb-4">
                <h5>Pengajuan Skema Terbaru</h5>
                <div class="table-responsive">
                    <table>
                        <thead>
                        <tr>
                            <th>Asesi</th>
                            <th>Program</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($pengajuanTerbaru as $pengajuan)
                            <tr>
                                <td>{{ $pengajuan->user->name ?? $pengajuan->user->nama ?? '-' }}</td>
                                <td>{{ Str::limit($pengajuan->program->nama ?? '-', 20) }}</td>
                                <td>
                                    @php
                                        $statusClass = match($pengajuan->status) {
                                            'pending' => 'bg-warning text-dark',
                                            'approved' => 'bg-success',
                                            'rejected' => 'bg-danger',
                                            'review' => 'bg-info',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        {{ ucfirst($pengajuan->status ?? 'pending') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    Belum ada pengajuan skema.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if($pengajuanTerbaru->count() > 0)
                <div class="text-end mt-2">
                    <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                @endif
            </div>

            <div class="admin-table">
                <h5>Status Sistem</h5>
                <p class="mb-2"><strong>Ringkasan:</strong></p>
                <ul class="mb-3">
                    <li>Pastikan data <b>Program Pelatihan</b> sudah lengkap sebelum dipublish.</li>
                    <li>Unit Kompetensi dan Profesi Terkait sebaiknya diisi untuk setiap program.</li>
                    <li>Jika ada perubahan SKKNI, segera update program terkait.</li>
                </ul>

                <hr>

                <p class="mb-2"><strong>Quick Action</strong></p>
                <button class="btn-admin btn-primary-admin mb-2"
                        onclick="window.location='{{ url('admin/program-pelatihan/create') }}'">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Program Baru
                </button>
                <button class="btn-admin mb-2"
                        style="background:#e5e7eb;"
                        onclick="window.open('{{ url('skema-sertifikasi') }}','_blank')">
                    Lihat Halaman Skema Publik
                </button>
            </div>
        </div>
    </div>

</div>

    </div>
    {{-- /KONTEN --}}

</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script>
    // toggle sidebar di mobile
    document.getElementById('sidebarToggle')
        ?.addEventListener('click', function () {
            document.getElementById('wrapper').classList.toggle('toggled');
        });
</script>



</body>
</html>
