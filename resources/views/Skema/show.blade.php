{{-- resources/views/skema/show.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Site Metas -->
    <title>Detail Skema – {{ $program->nama }} | LSP PLGM</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- quill css -->
    <link rel="stylesheet" href="{{ asset('vendor/quill/quill.snow.css') }}">
    <!-- Site Icons -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!--Bootstrap Icon-->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Site Fonts -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
    <!-- Slick Slider CSS -->
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}">
    <!-- PrettyPhoto CSS -->
    <link rel="stylesheet" href="{{ asset('css/prettyPhoto.css') }}">
    <!-- Site CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="{{ asset('js/modernizr.js') }}"></script>
</head>

<body id="page-top" class="politics_version">
<div class="page-wrapper">

    <!-- LOADER -->
    <div id="preloader">
        <div class="loader">
            <span></span><span></span><span></span><span></span>
        </div>
    </div>
    <!-- END LOADER -->

    <!-- TOP BAR ATAS -->
    <nav class="navbar top-navbar py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="navbar-nav flex-row">
                <a href="#" class="nav-link px-0 pr-3 top-icon"><i class="fa fa-facebook"></i></a>
                <a href="#" class="nav-link px-0 pr-3 top-icon"><i class="fa fa-instagram"></i></a>
                <a href="#" class="nav-link px-0 top-icon"><i class="fa fa-youtube-play"></i></a>
            </div>
            <div class="navbar-nav">
                <a href="{{ url('login') }}" class="nav-link px-0 top-icon">
                    Login
                </a>
            </div>
        </div>
    </nav>

    <!-- NAVBAR UTAMA -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="{{ url('/') }}">
                <img class="img-fluid nav-logo" src="{{ asset('images/logo.png') }}" alt="LSP" />
            </a>

            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                    aria-label="Toggle navigation">
                Menu <i class="fa fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="{{ url('/') }}">Beranda</a>
                    </li>

                    <!-- Dropdown PROFIL -->
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" id="profilDropdown" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            Profil <i class="bi dropdown-toggle"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="profilDropdown">
                            <a class="dropdown-item" href="{{ url('tentang-kami') }}">Tentang LSP</a>
                            <a class="dropdown-item" href="{{ url('visi-misi') }}">Visi &amp; Misi</a>
                            <a class="dropdown-item" href="{{ url('kebijakan-mutu') }}">Kebijakan &amp; Sasaran Mutu</a>
                            <a class="dropdown-item" href="{{ url('struktur-organisasi') }}">Struktur Organisasi</a>
                        </div>
                    </li>

                    <!-- Dropdown SERTIFIKASI -->
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" id="sertifikasiDropdown" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            Sertifikasi <i class="bi dropdown-toggle"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="sertifikasiDropdown">
                            <a class="dropdown-item" href="{{ url('skema-sertifikasi') }}">Skema Sertifikasi</a>
                            <a class="dropdown-item" href="{{ url('tempat-sertifikasi') }}">Tempat Uji Kompetensi</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="{{ url('daftar') }}">Daftar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END NAVBAR -->

    <!-- HEADER DETAIL SKEMA -->
    <section class="skema-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="skema-breadcrumb">
                        <a href="{{ url('/') }}">Beranda</a> /
                        <a href="{{ url('skema') }}">Skema Sertifikasi</a> /
                        <span>{{ $program->nama }}</span>
                    </div>
                    <h1 class="skema-title">{{ $program->nama }}</h1>

                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <span class="skema-tag">
                            <i class="bi bi-diagram-3"></i>
                            Bidang: {{ $program->kategori ?? '-' }}
                        </span>
                    </div>
                </div>

                <div class="col-lg-4 text-lg-right mt-3 mt-lg-0 skema-actions">
                    <a href="{{ url('daftar') }}" class="btn btn-skema-primary mb-2">
                        <i class="bi bi-check2-circle mr-1"></i> Daftar Uji Kompetensi
                    </a>

                    @auth
                        <a href="{{ route('pengajuan.create', $program->id) }}" class="btn btn-success mb-2">
                            <i class="bi bi-file-earmark-plus mr-1"></i> Daftar Skema Ini
                        </a>
                    @else
                        <a href="{{ route('login', ['intended' => route('pengajuan.create', $program->id)]) }}" class="btn btn-success mb-2">
                            <i class="bi bi-file-earmark-plus mr-1"></i> Daftar Skema Ini
                        </a>
                    @endauth

                    @if ($program->file_panduan)
                        <a href="{{ asset('storage/'.$program->file_panduan) }}"
                           class="btn btn-skema-outline mb-2" target="_blank">
                            <i class="bi bi-file-earmark-text mr-1"></i> Unduh Panduan Skema
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- KONTEN UTAMA SKEMA -->
    <section class="skema-main">
        <div class="container">

            <!-- META & RINGKASAN -->
            <div class="row">
                <div class="col-lg-5 mb-4">
                    <div class="skema-meta-card">
                        <h5 class="mb-3">Informasi Skema</h5>
                        @php
                            $biaya = $program->estimasi_biaya
                                ? 'Rp '.number_format($program->estimasi_biaya, 0, ',', '.')
                                : '-';
                        @endphp
                        <table>
                            <tr>
                                <th>Kode Skema</th>
                                <td>{{ $program->kode_skema }}</td>
                            </tr>
                            <tr>
                                <th>Bidang</th>
                                <td>{{ $program->kategori ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Rujukan SKKNI</th>
                                <td>{{ $program->rujukan_skkni ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Unit Kompetensi</th>
                                <td>{{ $program->jumlah_unit }} Unit</td>
                            </tr>
                            <tr>
                                <th>Estimasi Biaya</th>
                                <td>{{ $biaya }}</td>
                            </tr>
                            <tr>
                                <th>Masa Berlaku</th>
                                <td>3 Tahun</td> {{-- bisa dibuat kolom sendiri kalau mau dinamis --}}
                            </tr>
                        </table>
                        <p class="small text-muted mt-2 mb-0">
                            *Biaya dapat disesuaikan dengan kebijakan LSP/mitra penyelenggara.
                        </p>
                    </div>
                </div>

            <!-- RINGKASAN SKEMA - GANTI BAGIAN INI -->
                    <div class="col-lg-7 mb-4">
                        <div class="skema-ringkasan-card">
                    <h5>Ringkasan Skema</h5>
                    <div class="ql-editor quill-content">
                        {!! $program->ringkasan !!}
                    </div>
                </div>
            </div>

            <!-- TAB KONTEN -->
            <div class="skema-tabs-wrapper">
                <ul class="nav skema-tabs mb-0" id="skemaTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="unit-tab" data-toggle="tab" href="#unit"
                           role="tab" aria-controls="unit" aria-selected="true">
                            Unit Kompetensi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="syarat-tab" data-toggle="tab" href="#syarat"
                           role="tab" aria-controls="syarat" aria-selected="false">
                            Persyaratan Peserta
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="metode-tab" data-toggle="tab" href="#metode"
                           role="tab" aria-controls="metode" aria-selected="false">
                            Metode Asesmen
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="berlaku-tab" data-toggle="tab" href="#berlaku"
                           role="tab" aria-controls="berlaku" aria-selected="false">
                            Masa Berlaku &amp; Pemeliharaan
                        </a>
                    </li>
                </ul>

                <div class="tab-content" id="skemaTabContent">
                    <!-- TAB UNIT KOMPETENSI -->
                    <div class="tab-pane fade show active" id="unit" role="tabpanel"
                         aria-labelledby="unit-tab">
                        <div class="skema-tab-card mt-3">
                            <h5>Daftar Unit Kompetensi</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-unit">
                                    <thead>
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th style="width: 140px;">Kode Unit</th>
                                        <th>Judul Unit</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($program->units as $unit)
                                        <tr>
                                            <td>{{ $unit->no_urut ?? $loop->iteration }}</td>
                                            <td>{{ $unit->kode_unit }}</td>
                                            <td>{{ $unit->judul_unit }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-muted text-center">
                                                Belum ada data unit kompetensi.
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                   <!-- TAB SYARAT PESERTA - UPDATE BAGIAN INI -->
                    <div class="tab-pane fade" id="syarat" role="tabpanel" aria-labelledby="syarat-tab">
                        <div class="skema-tab-card mt-3">
                            <h5>Persyaratan Peserta</h5>
                            <div class="quill-content ql-editor">
                                {!! $program->persyaratan_peserta !!}
                            </div>
                        </div>
                    </div>

                    <!-- TAB METODE ASESMEN -->
                    <div class="tab-pane fade" id="metode" role="tabpanel"
                         aria-labelledby="metode-tab">
                        <div class="skema-tab-card mt-3">
                            <h5>Metode Asesmen</h5>
                            @php
                                $metodes = preg_split('/\r\n|[\r\n]/', $program->metode_asesmen ?? '');
                            @endphp
                            <ul>
                                @foreach ($metodes as $item)
                                    @if (trim($item) !== '')
                                        <li>{{ $item }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- TAB MASA BERLAKU -->
                    <div class="tab-pane fade" id="berlaku" role="tabpanel"
                         aria-labelledby="berlaku-tab">
                        <div class="skema-tab-card mt-3">
                            <h5>Masa Berlaku &amp; Pemeliharaan Sertifikat</h5>
                            <p>
                                Sertifikat kompetensi {{ $program->nama }} berlaku selama
                                <strong>3 (tiga) tahun</strong> sejak tanggal diterbitkan. Pemegang sertifikat
                                diharapkan:
                            </p>
                            <ul>
                                <li>Terus melakukan praktik sesuai ruang lingkup kompetensi.</li>
                                <li>Mengikuti pelatihan/peningkatan kompetensi secara berkala.</li>
                                <li>Melaporkan perkembangan portofolio saat pengajuan perpanjangan sertifikat.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

           <!-- PROFESI TERKAIT -->
            <div class="row mt-5">
                <div class="col-lg-6 mb-4">
                    <h5 class="mb-3">Profesi Terkait</h5>
                    <div>
                        @forelse ($program->profesiTerkait as $profesi)
                            <span class="chip-profesi">
                                <i class="bi {{ $profesi->icon ?? 'bi-briefcase' }}"></i>
                                {{ $profesi->nama }}
                            </span>
                        @empty
                            <p class="text-muted mb-0">Belum ada data profesi terkait.</p>
                        @endforelse
                    </div>
                </div>
            </div>


        </div>
    </section>
</div>

<!-- FOOTER UTAMA -->
<footer class="footer-lmc">
    <div class="container">
        <div class="row align-items-center py-4">

            <!-- Kontak -->
            <div class="col-md-4 mb-3 mb-md-0">
                <h5 class="footer-title">Kontak</h5>

                <p class="footer-item">
                    <i class="bi bi-geo-alt-fill me-2"></i>
                    <a href="https://maps.app.goo.gl/JRRkSUwuwzCuUWHt6" target="_blank">
                        Politeknik LP3I Bandung
                    </a>
                </p>

                <p class="footer-item">
                    <i class="bi bi-whatsapp me-2"></i>
                    <a href="https://wa.me/6285220199772" target="_blank">
                        0852-2019-9772
                    </a>
                </p>
            </div>

            <!-- Logo -->
            <div class="col-md-4 text-center mb-3 mb-md-0">
                <img src="{{ asset('images/logo.png') }}" width="120" alt="LSP Logo" class="footer-logo">
            </div>

            <!-- Sosial media -->
            <div class="col-md-4 text-md-right text-center">
                <div class="footer-sosmed">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

        </div>
    </div>
</footer>

<!-- COPYRIGHT -->
<div class="footer-copy">
    <div class="container text-center py-2">
        <p class="m-0">© {{ date('Y') }} LSP PLGM. All Rights Reserved.</p>
    </div>
</div>

<a href="#" id="scroll-to-top" class="dmtop global-radius">
    <i class="fa fa-angle-up"></i>
</a>

<!-- ALL JS FILES -->
<script src="{{ asset('js/all.js') }}"></script>
<script src="{{ asset('js/jquery.mobile.customized.min.js') }}"></script>
<script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
<script src="{{ asset('js/parallaxie.js') }}"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/animated-slider.js') }}"></script>
<script src="{{ asset('js/jqBootstrapValidation.js') }}"></script>
<script src="{{ asset('js/contact_me.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
