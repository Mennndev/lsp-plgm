{{-- resources/views/berita/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
  <!-- Basic -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <!-- Site Metas -->
  <title>Berita & Informasi - LSP PLGM</title>
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

  <!-- TOP BAR (SOSMED + TEXT) -->
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
  <!-- END TOP BAR -->

  <!-- NAVBAR UTAMA (copy dari skema-sertifikasi) -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="{{ url('/') }}">
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
            <a href="#" class="nav-link" id="profilDropdown" role="button" data-bs-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
              Profil
            </a>
            <div class="dropdown-menu" aria-labelledby="profilDropdown">
              <a class="dropdown-item" href="{{ url('tentang-kami') }}">Tentang LSP</a>
              <a class="dropdown-item" href="{{ url('visi-misi') }}">Visi &amp; Misi</a>
              <a class="dropdown-item" href="{{ url('kebijakan-mutu') }}">Kebijakan &amp; Sasaran Mutu</a>
              <a class="dropdown-item" href="{{ url('struktur-organisasi') }}">Struktur Organisasi</a>
            </div>
          </li>

          <li class="nav-item dropdown">
            <a href="#" class="nav-link" id="sertifikasiDropdown" role="button" data-bs-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
              Sertifikasi
            </a>
            <div class="dropdown-menu" aria-labelledby="sertifikasiDropdown">
              <a class="dropdown-item" href="{{ route('Skema.index') }}">Skema Sertifikasi</a>
              <a class="dropdown-item" href="{{ url('tempat-sertifikasi') }}">Tempat Uji Kompetensi</a>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link js-scroll-trigger active" href="{{ url('berita') }}">Berita</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="{{ url('daftar') }}">Daftar</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- END NAVBAR UTAMA -->

  <!-- ======= KONTEN BERITA ======= -->
  <section class="section lb" style="padding-top: 120px;">
    <div class="container">

      <!-- Header + Search -->
      <div class="row align-items-center mb-4">
        <div class="col-md-6 mb-3 mb-md-0">
          <h2 class="mb-1">Berita &amp; Informasi</h2>
          <p class="text-muted mb-0">
            Update terbaru seputar kegiatan dan informasi LSP Politeknik LP3I Global Mandiri.
          </p>
        </div>
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-text bg-white border-right-0">
              <i class="fa fa-search text-muted"></i>
            </span>
            <input type="text" class="form-control border-left-0" id="searchBerita"
                   placeholder="Cari judul berita atau kata kunci...">
          </div>
        </div>
      </div>

      <!-- GRID BERITA -->
      <div class="row g-4" id="daftarBerita">
        @forelse($beritas as $berita)
          <div class="col-md-4 col-sm-6 berita-item">
            <div class="card skema-card h-100 shadow-sm border-0">

              @if($berita->gambar)
                <img src="{{ asset('storage/'.$berita->gambar) }}"
                     class="card-img-top"
                     alt="{{ $berita->judul }}">
              @else
                <img src="{{ asset('images/default-berita.jpg') }}"
                     class="card-img-top"
                     alt="{{ $berita->judul }}">
              @endif

              <div class="card-body d-flex flex-column">
                <small class="text-muted mb-1">
                  <i class="bi bi-calendar-event"></i>
                  {{ \Carbon\Carbon::parse($berita->tanggal_terbit ?? $berita->created_at)->translatedFormat('d F Y') }}
                </small>

                <h5 class="card-title mb-2">{{ $berita->judul }}</h5>

                <p class="card-text text-muted small mb-3">
                  {{ \Illuminate\Support\Str::limit(strip_tags($berita->ringkasan ?: $berita->konten), 140) }}
                </p>

                <a href="{{ route('berita.show', $berita->slug ?? $berita->id) }}"
                   class="btn btn-sm btn-primary mt-auto">
                  Baca Selengkapnya
                </a>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <p class="text-muted">Belum ada berita yang dipublikasikan.</p>
          </div>
        @endforelse
      </div>

      <!-- PAGINATION -->
      <div class="mt-4 d-flex justify-content-center">
        {{ $beritas->links() }}
      </div>

    </div>
  </section>
  <!-- ===== END KONTEN BERITA ===== -->

</div>

<!-- FOOTER (copy dari skema-sertifikasi) -->
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

<!-- Bootstrap 5 Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<!-- Other legacy JS plugins -->
<!-- ALL JS FILES -->
<script src="{{ asset('js/jquery.mobile.customized.min.js') }}"></script>
<script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
<script src="{{ asset('js/parallaxie.js') }}"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/animated-slider.js') }}"></script>
<script src="{{ asset('js/jqBootstrapValidation.js') }}"></script>
<script src="{{ asset('js/contact_me.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>

<script>
  const searchInput = document.getElementById('searchBerita');
  const beritaItems = document.querySelectorAll('.berita-item');

  function filterBerita() {
    const keyword = searchInput.value.toLowerCase().trim();

    beritaItems.forEach(item => {
      const text = item.innerText.toLowerCase();
      item.style.display = (keyword === '' || text.includes(keyword)) ? '' : 'none';
    });
  }

  if (searchInput) {
    searchInput.addEventListener('input', filterBerita);
  }
</script>
</body>
</html>
    