{{-- resources/views/visi-misi.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Site Metas -->
    <title>Visi &amp; Misi - LSP PLGM</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Site Icons -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!--Bootstrap Icon-->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Site Fonts -->
     <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    <script src="{{ asset('js/modernizr.js') }}"></script> <!-- Modernizr -->

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body id="page-top" class="politics_version">

<div class="page-wrapper">

    <!-- LOADER -->
    <div id="preloader">
        <div class="loader">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <!-- END LOADER -->

    <!-- TOP NAVBAR ATAS -->
    <nav class="navbar top-navbar py-2">
        <div class="container d-flex justify-content-between align-items-center">

            <!-- Kiri: Sosial Media -->
            <div class="navbar-nav flex-row">
                <a href="#" class="nav-link px-0 pr-3 top-icon">
                    <i class="fa fa-facebook"></i>
                </a>
                <a href="#" class="nav-link px-0 pr-3 top-icon">
                    <i class="fa fa-instagram"></i>
                </a>
                <a href="#" class="nav-link px-0 top-icon">
                    <i class="fa fa-youtube-play"></i>
                </a>
            </div>

            <!-- Kanan: Login -->
            <div class="navbar-nav">
                <a href="{{ url('login') }}" class="nav-link px-0 top-icon">
                    Login
                </a>
            </div>
        </div>
    </nav>
    <!-- END TOP NAVBAR ATAS -->

<!-- NAVBAR UTAMA -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">
                <img class="img-fluid nav-logo" src="{{ asset('images/logo.png') }}" alt="LSP" />
            </a>

            <button class="navbar-toggler navbar-toggler-right" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false"
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
                        <a href="#" class="nav-link dropdown-toggle"
                           id="profilDropdown" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Profil
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
                        <a href="#" class="nav-link dropdown-toggle"
                           id="sertifikasiDropdown" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Sertifikasi
                        </a>
                        <div class="dropdown-menu" aria-labelledby="sertifikasiDropdown">
                            <a class="dropdown-item" href="{{ route('Skema.index') }}">Skema Sertifikasi</a>
                            <a class="dropdown-item" href="{{ url('tempat-sertifikasi') }}">Tempat Uji Kompetensi</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="{{ url('berita') }}">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="{{ url('pendaftaran') }}">Daftar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END NAVBAR UTAMA -->

    <section id="visi" class="visi-header-modern">
        <div class="container" data-aos="fade-up">
            <h2 class="visi-title">Visi &amp; Misi</h2>
            <div class="visi-underline"></div>
        </div>

        <div class="visi-deco">
            <img src="{{ asset('images/logo.png') }}" alt="Logo LPK LP3I Mandiri Center"
                 class="visi-logo-modern">
        </div>
    </section>

    <!-- ====== VISI & MISI - VERSI SEDERHANA ====== -->
    <section id="visi-misi" class="section wb visi-misi">
        <div class="container">
            <div class="section-title text-center">
                <h3>Visi &amp; Misi</h3>
                <p>Lembaga Sertifikasi Profesi di lingkungan Politeknik LP3I Bandung.</p>
            </div>

            <div class="row">
                <!-- Visi -->
                <div class="col-md-4">
                    <h4 class="mb-3"><strong>Visi</strong></h4>
                    <p>
                        Menjadi Lembaga Sertifikasi Profesi yang unggul dan profesional
                        sesuai Standar Kompetensi Kerja Nasional Indonesia (SKKNI) dan standar global.
                    </p>
                </div>

                <!-- Misi -->
                <div class="col-md-8">
                    <h4 class="mb-3"><strong>Misi</strong></h4>
                    <ol style="list-style: decimal; margin-left: 20px;">
                        <li>Menyelenggarakan sertifikasi kompetensi kerja secara independen, objektif, dan akuntabel.</li>
                        <li>Mengembangkan sumber daya manusia yang kompeten dan berdaya saing global.</li>
                        <li>Menyusun dan memutakhirkan skema sertifikasi sesuai kebutuhan industri dan dunia kerja.</li>
                        <li>Membangun kolaborasi strategis dengan industri, asosiasi profesi, dan institusi pendidikan.</li>
                        <li>Mengelola lembaga sertifikasi secara profesional, transparan, serta menjunjung tinggi integritas.</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- ====== END VISI & MISI SEDERHANA ====== -->

</div> {{-- end .page-wrapper --}}

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

<!-- jQuery (for legacy plugins) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<!-- Bootstrap 5 Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<!-- Other legacy JS plugins -->
<!-- ALL JS FILES -->
<script src="{{ asset('js/jquery.mobile.customized.min.js') }}"></script>
<script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
<script src="{{ asset('js/parallaxie.js') }}"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/animated-slider.js') }}"></script>
<!-- Contact form JavaScript -->
<script src="{{ asset('js/jqBootstrapValidation.js') }}"></script>
<script src="{{ asset('js/contact_me.js') }}"></script>
<!-- ALL PLUGINS -->
<script src="{{ asset('js/custom.js') }}"></script>

<script src="{{ asset('js/aos.js') }}"></script>

<script>
    $(document).ready(function () {


         // --- 1. Init Animations ---
        AOS.init({
            once: true,
            duration: 700,
            easing: 'ease-out-cubic'
    });

    // (script JS kamu tetap sama, tidak perlu diubah untuk Blade)
    const navToggle = document.querySelector('.mobile-nav-toggle');
    const navMenu = document.querySelector('#navbar ul');

    if (navToggle && navMenu) {
        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('show');

            if (navMenu.classList.contains('show')) {
                navToggle.classList.remove('bi-list');
                navToggle.classList.add('bi-x');
            } else {
                navToggle.classList.remove('bi-x');
                navToggle.classList.add('bi-list');
            }
        });
    }

    document.querySelectorAll('#navbar a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 991 && link.parentElement.classList.contains('dropdown')) {
                return;
            }

            if (navMenu && navMenu.classList.contains('show')) {
                navMenu.classList.remove('show');
                navToggle.classList.remove('bi-x');
                navToggle.classList.add('bi-list');
            }
        });
    });

    document.querySelectorAll('#navbar .dropdown > a').forEach(trigger => {
        trigger.addEventListener('click', function (e) {
            if (window.innerWidth <= 991) {
                e.preventDefault();
                const parentLi = this.parentElement;

                document.querySelectorAll('#navbar .dropdown').forEach(li => {
                    if (li !== parentLi) {
                        li.classList.remove('dropdown-active');
                    }
                });

                parentLi.classList.toggle('dropdown-active');
            }
        });
    });

    window.addEventListener('scroll', function () {
        var scrolled = window.scrollY || window.pageYOffset;

        if (scrolled > 80) {
            document.body.classList.add('hide-top-navbar');
        } else {
            document.body.classList.remove('hide-top-navbar');
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const links = document.querySelectorAll('.kategori-link');
        const items = document.querySelectorAll('.kategori-item');

        function filterKategori(filter) {
            links.forEach(link => {
                link.classList.toggle('active', link.dataset.filter === filter);
            });

            items.forEach(item => {
                if (filter === 'all') {
                    item.classList.remove('d-none');
                    return;
                }

                const katArray = (item.dataset.kategori || '').split(' ');
                const match = katArray.includes(filter);

                if (match) {
                    item.classList.remove('d-none');
                } else {
                    item.classList.add('d-none');
                }
            });
        }

        links.forEach(link => {
            link.addEventListener('click', function () {
                const filter = this.dataset.filter || 'all';
                filterKategori(filter);
            });
        });

        filterKategori('all');
    });

        });
</script>

</body>
</html>
