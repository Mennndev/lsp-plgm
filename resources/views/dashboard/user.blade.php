<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard LSP - Pengguna</title>

    {{-- Bootstrap & FontAwesome (boleh diganti ke asset lokal kalau mau) --}}
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap"
          rel="stylesheet">

    {{-- CSS khusus dashboard user --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard-user.css') }}">
</head>
<body>
<div id="wrapper" class="toggled">
    {{-- SIDEBAR --}}
    <div id="sidebar-wrapper">
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Logo LSP"
                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22160%22 height=%2260%22%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2216%22 fill=%22%234e73df%22%3ELSP Logo%3C/text%3E%3C/svg%3E'">
        </div>
        <ul class="sidebar-nav">
            <li>
                <a href="#" class="active menu-link" data-target="beranda">
                    <i class="fa fa-dashboard"></i> Beranda
                </a>
            </li>
            <li>
                <a href="#" class="menu-link" data-target="pengajuan">
                    <i class="fa fa-file-text-o"></i> Pengajuan Skema
                </a>
            </li>
            <li>
                <a href="#" class="menu-link" data-target="riwayat">
                    <i class="fa fa-history"></i> Riwayat Asesmen
                </a>
            </li>
        </ul>
    </div>

    {{-- PAGE CONTENT --}}
    <div id="page-content-wrapper">
        {{-- TOP NAVBAR --}}
        <nav class="navbar navbar-custom navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="menu-toggle" id="menu-toggle">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <ul class="nav navbar-nav navbar-right">
                    {{-- Notification Dropdown --}}
                    <li class="dropdown notification-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            @if($notificationCount > 0)
                                <span class="badge badge-danger">{{ $notificationCount }}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right notification-menu">
                            <div class="notification-header">
                                <span>Notifikasi</span>
                                @if($notificationCount > 0)
                                    <form action="{{ route('notifications.readAll') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-link btn-sm p-0">Tandai semua dibaca</button>
                                    </form>
                                @endif
                            </div>
                            <div class="notification-body">
                                @forelse($latestNotifications as $notif)
                                    <a href="{{ route('notifications.read', $notif->id) }}" 
                                       class="notification-item {{ $notif->is_read ? '' : 'unread' }}">
                                        <div class="notification-icon text-{{ $notif->type }}">
                                            <i class="bi {{ $notif->icon }}"></i>
                                        </div>
                                        <div class="notification-content">
                                            <p class="notification-title">{{ $notif->title }}</p>
                                            <p class="notification-text">{{ \Illuminate\Support\Str::limit($notif->message, 50) }}</p>
                                            <small class="notification-time">{{ $notif->time_ago }}</small>
                                        </div>
                                    </a>
                                @empty
                                    <div class="notification-empty">
                                        <i class="fa fa-bell-slash-o"></i>
                                        <p>Tidak ada notifikasi</p>
                                    </div>
                                @endforelse
                            </div>
                            @if($latestNotifications->count() > 0)
                                <div class="notification-footer">
                                    <a href="{{ route('notifications.index') }}">Lihat Semua Notifikasi</a>
                                </div>
                            @endif
                        </div>
                    </li>

                    {{-- User Dropdown --}}
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama ?? $user->name ?? 'User') }}&background=4e73df&color=fff"
                                 alt="User">
                            <span class="hidden-xs">{{ $user->nama ?? $user->name ?? 'User' }}</span>
                            <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('ProfileUser.edit') }}"><i class="fa fa-user"></i> Profil Saya</a></li>
                            <li class="divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" style="margin:0;padding:0;">
                                    @csrf
                                    <button type="submit" class="btn btn-link btn-block text-left"
                                            style="color:#333; padding: 6px 20px;">
                                        <i class="fa fa-sign-out"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        {{-- MAIN CONTENT --}}
        <div class="main-content">
            {{-- BERANDA --}}
            <div id="beranda" class="content-section active">
                <div class="page-header page-header-beranda">
                    <h1><i class="fa fa-home"></i> Beranda</h1>
                    <p>Ringkasan jadwal asesmen Anda.</p>
                </div>

                {{-- Filter (belum pakai DB, nanti bisa dihubungkan) --}}
                <div class="row filter-row">
                    <div class="col-md-4">
                        <input type="text" class="form-control"
                               placeholder="Cari asesmen">
                    </div>
                    <div class="col-md-4">
                        <select class="form-control">
                            <option>Status asesmen</option>
                            <option>Semua Status</option>
                            <option>Menunggu</option>
                            <option>Selesai</option>
                            <option>Belum Dimulai</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive table-custom">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Asesmen</th>
                            <th>Skema Sertifikasi</th>
                            <th>TUK</th>
                            <th>Alamat</th>
                            <th>Tanggal Asesmen</th>
                            <th>Link Virtual Meeting</th>
                            <th>Asesor</th>
                            <th>Jenis Bukti</th>
                            <th>Rekomendasi</th>
                            <th>Status</th>
                            <th>Status Asesmen</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($asesmenList as $asesmen)
                            {{-- TODO: sesuaikan field di bawah dengan kolom tabel asesmen kamu --}}
                            <tr>
                                <td>{{ $asesmen->kode ?? '-' }}</td>
                                <td>{{ $asesmen->skema_nama ?? '-' }}</td>
                                <td>{{ $asesmen->tuk_nama ?? '-' }}</td>
                                <td>{{ $asesmen->tuk_alamat ?? '-' }}</td>
                                <td>{{ $asesmen->tanggal_asesmen ?? '-' }}</td>
                                <td>
                                    @if(!empty($asesmen->link_meeting))
                                        <a href="{{ $asesmen->link_meeting }}" target="_blank">Link</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $asesmen->asesor_nama ?? '-' }}</td>
                                <td>{{ $asesmen->jenis_bukti ?? '-' }}</td>
                                <td>{{ $asesmen->rekomendasi ?? '-' }}</td>
                                <td>{{ $asesmen->status ?? '-' }}</td>
                                <td>{{ $asesmen->status_asesmen ?? '-' }}</td>
                                <td>
                                    {{-- contoh tombol detail --}}
                                    <button class="btn btn-xs btn-primary btn-custom">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center empty-table">
                                    <i class="fa fa-inbox empty-icon"></i>
                                    <p>Tidak ada data</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- PENGAJUAN SKEMA --}}
            <div id="pengajuan" class="content-section">
                <div class="page-header page-header-pengajuan">
                    <div class="pull-left">
                        <h1><i class="fa fa-file-text-o"></i> Pengajuan Skema</h1>
                        <p>Daftar skema sertifikasi yang diajukan.</p>
                    </div>
                <div class="pull-right">
                    <a href="{{ route('pengajuan.pilih-skema') }}" class="btn btn-page-header">
                        <i class="fa fa-plus"></i> Ajukan Skema Baru
                    </a>
                </div>
                    <div class="clearfix"></div>
                </div>

                <div class="table-responsive table-custom">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="35%">Nama Skema</th>
                            <th width="15%">Tanggal Pengajuan</th>
                            <th width="15%">Status Dokumen</th>
                            <th width="15%">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($pengajuanList as $index => $pengajuan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pengajuan->program->nama ?? '-' }}</td>
                                <td>{{ $pengajuan->tanggal_pengajuan ? $pengajuan->tanggal_pengajuan->format('d/m/Y H:i') : '-' }}</td>
                                <td>
                                    <span class="status-badge {{ $pengajuan->status }}">
                                        {{ $pengajuan->status_label }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('pengajuan.show', $pengajuan->id) }}" class="btn btn-success btn-xs btn-custom">Lihat Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center empty-table">
                                    <i class="fa fa-inbox empty-icon"></i>
                                    <p>Belum ada pengajuan skema</p>
                                    <a href="{{ route('pengajuan.pilih-skema') }}" class="btn btn-primary btn-sm">Ajukan Skema Sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- RIWAYAT ASESMENT --}}
            <div id="riwayat" class="content-section">
                <div class="page-header page-header-riwayat">
                    <div class="pull-left">
                        <h1><i class="fa fa-history"></i> Riwayat Asesmen</h1>
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-page-header">
                            <i class="fa fa-ellipsis-v"></i> Aksi
                        </button>
                    </div>
                    <div class="clearfix"></div>
                </div>

                {{-- Search --}}
                <div class="row filter-row">
                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="text" class="form-control"
                                   placeholder="Cari skema sertifikasi">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search" style="color:#999;"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="table-responsive table-custom">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Skema Sertifikasi</th>
                            <th>Jenis Bukti</th>
                            <th>Nomor Sertifikat</th>
                            <th>Tanggal Berlaku</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($riwayatList as $riwayat)
                            {{-- TODO: sesuaikan field dengan kolom tabel riwayat asesmen --}}
                            <tr>
                                <td>{{ $riwayat->nama_skema ?? '-' }}</td>
                                <td>{{ $riwayat->jenis_bukti ?? '-' }}</td>
                                <td>{{ $riwayat->nomor_sertifikat ?? '-' }}</td>
                                <td>{{ $riwayat->tanggal_berlaku ?? '-' }}</td>
                                <td>{{ $riwayat->status ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center empty-table">
                                    <i class="fa fa-inbox empty-icon"></i>
                                    <p>Tidak ada data</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Dummy scrollbar dekoratif --}}
                <div class="fake-scrollbar-wrapper">
                    <div class="fake-scrollbar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JS CDN --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        // Toggle Sidebar
        $("#menu-toggle").click(function (e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });

        // Menu Navigation
        $(".menu-link").click(function (e) {
            e.preventDefault();

            $(".menu-link").removeClass("active");
            $(this).addClass("active");

            $(".content-section").removeClass("active");
            var target = $(this).data("target");
            $("#" + target).addClass("active");

            if ($(window).width() < 768) {
                $("#wrapper").removeClass("toggled");
            }
        });

        // Close sidebar ketika klik di luar sidebar (mobile)
        $(document).click(function (e) {
            if ($(window).width() < 768) {
                if (!$(e.target).closest('#sidebar-wrapper, #menu-toggle').length) {
                    if ($("#wrapper").hasClass("toggled")) {
                        $("#wrapper").removeClass("toggled");
                    }
                }
            }
        });
    });
</script>


</body>
</html>
