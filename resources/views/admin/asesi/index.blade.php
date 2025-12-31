{{-- resources/views/admin/asesi/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Data Asesi – LSP PLGM</title>

    {{-- Bootstrap 5 & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw==" crossorigin="anonymous" referrerpolicy="no-referrer">

    {{-- CSS Admin --}}
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
</head>

<body class="admin-body">
<div id="wrapper">

    {{-- ================= SIDEBAR ================= --}}
    <div id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/logo.png') }}" alt="LSP PLGM">
            </a>
        </div>

        <ul class="sidebar-nav">
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

            <li class="{{ request() ->is('admin/pengajuan*') ? 'active' : '' }}">
                <a href="{{ url('admin/pengajuan') }}">
                    <i class="bi bi-file-earmark-text"></i> Pengajuan Sertifikasi
                </a>
            </li>

            <li class="{{ request()->is('admin/pengguna*') ? 'active' : '' }}">
                <a href="{{ url('admin/berita') }}">
                    <i class="bi bi-newspaper"></i> Berita
                </a>
            </li>
        </ul>
    </div>
    {{-- =============== /SIDEBAR =============== --}}

    {{-- =============== MAIN CONTENT =============== --}}
    <div id="page-content-wrapper">

        {{-- NAVBAR ATAS --}}
        <nav class="admin-navbar">
            <div class="nav-title">
                Data Asesi
            </div>

            <div class="admin-user">
                <span class="text-muted d-none d-sm-inline">
                    {{ now()->format('d M Y') }}
                </span>

                <div class="dropdown">
                    <a class="dropdown-toggle text-decoration-none" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ auth()->user()->name ?? 'Administrator' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-gear me-1"></i> Pengaturan Akun
                            </a>
                        </li>
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
        {{-- /NAVBAR --}}

        <div class="admin-content">

            {{-- ================== STAT KECIL DI ATAS ================== --}}
            <section class="admin-stats mb-4">
                <div class="admin-card">
                    <div class="info">
                        <h6>Total Asesi</h6>
                        <h3>{{ $totalAsesi ?? 0 }}</h3>
                        <small class="text-muted">Seluruh akun yang terdaftar</small>
                    </div>
                    <div class="icon">
                        <i class="bi bi-people"></i>
                    </div>
                </div>


            </section>

            {{-- ================== FILTER & TABEL ================== --}}
            <div class="admin-table">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                    <h5 class="mb-2 mb-md-0">Daftar Asesi</h5>

                    {{-- FORM FILTER (opsional, method GET) --}}
                                    <form method="GET" action="{{ url('admin/asesi') }}" class="row g-2 mb-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control"
                            placeholder="Cari nama/email/skema..."
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">-- Semua Status --</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary w-100" type="submit">
                            <i class="bi bi-search me-1"></i> Filter
                        </button>
                    </div>
                </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Asesi</th>
                            <th>Email</th>
                            <th>Skema</th>
                            <th>Jadwal</th>
                            <th>Kota</th>
                            <th style="width: 130px;">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($asesiList as $index => $item)
                            <tr>
                                <td>{{ ($asesiList->currentPage() - 1) * $asesiList->perPage() + $index + 1 }}</td>

                                {{-- Nama dari relasi user, fallback ke kolom nama di pendaftarans kalau ada --}}
                                <td>{{ $item->user->nama ?? ($item->nama ?? '-') }}</td>

                                <td>{{ $item->email }}</td>

                                {{-- Skema dari relasi program atau kolom skema --}}
                                <td>{{ $item->program->nama ?? $item->skema ?? '-' }}</td>

                                <td>{{ $item->jadwal ?? '-' }}</td>
                                <td>{{ $item->kota ?? '-' }}</td>

                                <td>
                                    <a href="{{ url('admin/asesi/'.$item->id) }}"
                                       class="btn btn-sm btn-outline-secondary mb-1">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    @if($item->ktp_path)
                                        <a href="{{ asset('storage/'.$item->ktp_path) }}"
                                           class="btn btn-sm btn-outline-primary mb-1" target="_blank">
                                            <i class="bi bi-credit-card-2-front"></i>
                                        </a>
                                    @endif
                                    @if($item->ttd_path)
                                        <a href="{{ asset('storage/'.$item->ttd_path) }}"
                                           class="btn btn-sm btn-outline-success mb-1" target="_blank">
                                            <i class="bi bi-pen"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    Belum ada data asesi.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION (kalau pakai paginate()) --}}
                @if(method_exists($asesiList, 'links'))
                    <div class="mt-3">
                        {{ $asesiList->links() }}
                    </div>
                @endif
            </div>

        </div>
        {{-- /.admin-content --}}
    </div>
    {{-- =============== /MAIN CONTENT =============== --}}

</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
