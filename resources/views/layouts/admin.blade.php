<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin – LSP PLGM')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- ADMIN CSS (KHUSUS) -->
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    
    @stack('styles')
</head>

<body class="admin-body">

<div id="wrapper">

    <!-- ✅ SIDEBAR -->
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="LSP PLGM">
        </div>

        <ul class="sidebar-nav">
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>

            <li class="{{ request()->is('admin/program-pelatihan*') ? 'active' : '' }}">
                <a href="{{ route('admin.program-pelatihan.index') }}">
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
    </aside>

    <!-- ✅ KONTEN -->
    <main id="page-content-wrapper">

        <!-- ✅ NAVBAR ATAS -->
        <nav class="admin-navbar">
            <button id="menu-toggle" class="btn">
                <i class="bi bi-list"></i>
            </button>

            <div class="admin-user">
                <span class="text-muted me-3">Panel Admin LSP PLGM</span>

                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                        {{ auth()->user()->name ?? 'Administrator' }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">
                            <i class="bi bi-gear"></i> Pengaturan Akun
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- ✅ KONTEN DINAMIS -->
        <section class="admin-content">
            @yield('content')
        </section>

    </main>

</div>

<!-- jQuery (optional, for legacy code) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap 5 Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Admin custom JS -->
<script>
    document.getElementById('menu-toggle').onclick = function () {
        document.getElementById('wrapper').classList.toggle('toggled');
    }
</script>

@stack('scripts')

</body>
</html>
