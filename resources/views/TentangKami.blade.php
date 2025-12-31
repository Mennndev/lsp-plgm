{{-- resources/views/tentang-kami.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title>Tentang Kami - LSP PLGM</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon" />
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/prettyPhoto.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">



    <script src="{{ asset('js/modernizr.js') }}"></script> </head>

<body id="page-top" class="politics_version">

<div class="page-wrapper">

    <div id="preloader">
        <div class="loader">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <nav class="navbar top-navbar py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="navbar-nav flex-row">
                <a href="#" class="nav-link px-0 pr-3 top-icon"><i class="fa fa-facebook"></i></a>
                <a href="#" class="nav-link px-0 pr-3 top-icon"><i class="fa fa-instagram"></i></a>
                <a href="#" class="nav-link px-0 top-icon"><i class="fa fa-youtube-play"></i></a>
            </div>
            <div class="navbar-nav">
                <a href="{{ url('login') }}" class="nav-link px-0 top-icon">Login</a>
            </div>
        </div>
    </nav>
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
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ url('/') }}">Beranda</a></li>

                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="profilDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Profil
                        </a>
                        <div class="dropdown-menu" aria-labelledby="profilDropdown">
                            <a class="dropdown-item" href="{{ url('tentang-kami') }}">Tentang LSP</a>
                            <a class="dropdown-item" href="{{ url('visi-misi') }}">Visi & Misi</a>
                            <a class="dropdown-item" href="{{ url('kebijakan-mutu') }}">Kebijakan & Sasaran Mutu</a>
                            <a class="dropdown-item" href="{{ url('struktur-organisasi') }}">Struktur Organisasi</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="sertifikasiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{ url('pendaftaran') }}">Daftar</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section id="tentang" class="tentang-header-modern">
        <div class="container" data-aos="fade-up">
            <h2 class="tentang-title">Tentang Kami</h2>
            <div class="tentang-underline"></div>
        </div>
        <div class="tentang-deco">
            <img src="images/logo.png" alt="Logo LPK LP3I Mandiri Center" class="tentang-logo-modern">
        </div>
    </section>

    <div class="container py-5">
        <div class="row gy-4">
            <div class="col-lg-8 tentang">
                <p>
                    Lembaga Sertifikasi Profesi (LSP) Politeknik LP3I Global Mandiri adalah lembaga pendukung BNSP yang diberi
                    mandat untuk menyelenggarakan sertifikasi kompetensi profesi bagi peserta didik dan sumber daya manusia jejaring
                    kerja Politeknik LP3I. LSP P1 ini dibentuk untuk memastikan lulusan memiliki pengakuan kompetensi yang diakui
                    secara nasional dan siap bersaing di dunia kerja.
                </p>

                <h2><b>Latar Belakang</b></h2>
                <p>
                    LSP Politeknik LP3I Global Mandiri didirikan oleh Politeknik LP3I di bawah Yayasan Global Mandiri Utama
                    melalui Surat Keputusan Direktur Nomor 738/DIR/B1/POLTEK-LP3I/VII/2025 tertanggal 7 Juli 2025. Keberadaan LSP
                    ini menjadi bagian penting dari komitmen institusi untuk mendukung program pemerintah di bidang sertifikasi
                    profesi dan peningkatan kualitas sumber daya manusia.
                </p>

                <h2><b>Komitmen Mutu</b></h2>
                <p>
                    Dalam pelaksanaan sertifikasi, LSP Politeknik LP3I Global Mandiri berkomitmen untuk:
                    Menjaga ketidakberpihakan dan menghindari benturan kepentingan dalam setiap proses sertifikasi.
                    Menerapkan sistem manajemen mutu sesuai Pedoman BNSP 201 dan ISO 17024.
                    Menyelenggarakan uji kompetensi secara objektif, transparan, dan dapat dipertanggungjawabkan, sehingga hasil
                    sertifikasi benar-benar mencerminkan kompetensi peserta.
                </p>
            </div>
        </div>
    </div>

</div> {{-- end .page-wrapper --}}

<footer class="footer-lmc">
    <div class="container">
        <div class="row align-items-center py-4">
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

            <div class="col-md-4 text-center mb-3 mb-md-0">
                <img src="{{ asset('images/logo.png') }}" width="120" alt="LSP Logo" class="footer-logo">
            </div>

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

<script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>

<script src="{{ asset('js/isotope.pkgd.min.js') }}"></script>

<!-- Bootstrap 5 Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
<script src="{{ asset('js/parallaxie.js') }}"></script>

<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/aos.js') }}"></script>

<script src="{{ asset('js/animated-slider.js') }}"></script>
<script src="{{ asset('js/jqBootstrapValidation.js') }}"></script>
<script src="{{ asset('js/contact_me.js') }}"></script>

<script src="{{ asset('js/custom.js') }}"></script>

<script>
    // Jalankan semua logic setelah dokumen siap agar tidak error
    $(document).ready(function() {

        // --- 1. Init Animations ---
        AOS.init({
            once: true,
            duration: 700,
            easing: 'ease-out-cubic'
        });

        // --- 2. Mobile Navbar Logic ---
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

        // --- 3. Dropdown Logic (Mobile Support) ---
        // Menggunakan jQuery untuk mempermudah toggle dropdown
        $('.dropdown-toggle').click(function(e) {
            if ($(window).width() <= 991) {
                e.preventDefault();
                e.stopPropagation();
                $(this).closest('.dropdown').toggleClass('show');
                $(this).next('.dropdown-menu').toggleClass('show');
            }
        });

        // --- 4. Scroll Effect ---
        $(window).scroll(function () {
            if ($(this).scrollTop() > 80) {
                $('body').addClass('hide-top-navbar');
            } else {
                $('body').removeClass('hide-top-navbar');
            }
        });

        // --- 5. Filter Kategori (Jika ada di halaman ini) ---
        const links = document.querySelectorAll('.kategori-link');
        const items = document.querySelectorAll('.kategori-item');

        if(links.length > 0){
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
                    if (katArray.includes(filter)) {
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
        }
    });
</script>
</body>
</html>
