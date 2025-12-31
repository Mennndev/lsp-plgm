<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notifikasi - LSP PLGM</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw==" crossorigin="anonymous" referrerpolicy="no-referrer">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

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
                <a href="{{ route('dashboard.user') }}" class="menu-link">
                    <i class="fa fa-dashboard"></i> Beranda
                </a>
            </li>
            <li>
                <a href="{{ route('notifications.index') }}" class="menu-link active">
                    <i class="fa fa-bell"></i> Notifikasi
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
                    {{-- User Dropdown --}}
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nama ?? 'User') }}&background=4e73df&color=fff" alt="User">
                            <span class="d-none d-sm-inline">{{ auth()->user()->nama ?? 'User' }}</span>
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
            <div class="container-fluid">
                <div class="page-header page-header-pengajuan">
                    <h1><i class="fa fa-bell"></i> Notifikasi</h1>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="panel panel-default">
                    <div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
                        <span>Semua Notifikasi</span>
                        @if($unreadCount > 0)
                            <form action="{{ route('notifications.readAll') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="bi bi-check-all"></i> Tandai Semua Dibaca
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="panel-body" style="padding: 0;">
                        @forelse($notifications as $notif)
                            <div class="notification-list-item {{ $notif->is_read ? 'read' : 'unread' }}">
                                <div class="notification-icon text-{{ $notif->type }}">
                                    <i class="bi {{ $notif->icon }} fs-4"></i>
                                </div>
                                <div class="notification-content flex-grow-1">
                                    <h6 class="mb-1">{{ $notif->title }}</h6>
                                    <p class="mb-1 text-muted">{{ $notif->message }}</p>
                                    <small class="text-muted">{{ $notif->time_ago }}</small>
                                </div>
                                <div class="notification-actions">
                                    @if(!$notif->is_read)
                                        <form action="{{ route('notifications.read', $notif->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Tandai dibaca">
                                                <i class="bi bi-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if($notif->link)
                                        <a href="{{ $notif->link }}" class="btn btn-sm btn-primary" title="Lihat detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    @endif
                                    <form action="{{ route('notifications.destroy', $notif->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus" 
                                                onclick="return confirm('Hapus notifikasi ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="text-center" style="padding: 60px 20px;">
                                <i class="bi bi-bell-slash" style="font-size: 64px; color: #d1d5db; display: block; margin-bottom: 15px;"></i>
                                <p class="text-muted">Tidak ada notifikasi</p>
                            </div>
                        @endforelse
                    </div>
                    @if($notifications->hasPages())
                        <div class="panel-footer">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

{{-- Bootstrap 5 Bundle (includes Popper) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script>
    // Toggle sidebar
    $('#menu-toggle').click(function(e) {
        e.preventDefault();
        $('#wrapper').toggleClass('toggled');
    });
</script>
</body>
</html>
