{{-- resources/views/profile/edit.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - LSP PLGM</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw==" crossorigin="anonymous" referrerpolicy="no-referrer">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap"
          rel="stylesheet">

    {{-- CSS khusus halaman profil --}}
    <link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}">
</head>
<body>

{{-- BAR ATAS --}}
<header class="pe-header">
    <div class="container-fluid pe-header-inner">
        <div>
            <h1 class="pe-title">Profile</h1>
            <p class="pe-subtitle">
                Kelola informasi akun, data pribadi, tanda tangan digital, dan keamanan akun Anda.
            </p>
        </div>

        <div class="pe-header-actions">
            {{-- Notifikasi sukses update profil --}}
            @if (session('status') === 'profile-updated')
                <span class="pe-badge-success">Profil berhasil diperbarui</span>
            @endif

            {{-- Notifikasi sukses update password --}}
            @if (session('password-updated'))
                <span class="pe-badge-success">Password berhasil diubah</span>
            @endif

            <a href="{{ route('dashboard.user') }}" class="btn btn-outline-gold btn-sm">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>

            {{-- Tombol submit untuk form profil (kiri) --}}
            <button type="submit" form="profileForm" class="btn btn-blue btn-sm">
                <i class="fa fa-save"></i> Simpan Profil
            </button>
        </div>
    </div>
</header>

<main class="pe-main">
    <div class="container-fluid">

        <div class="row">
            {{-- KOLOM KIRI: Detail akun + data pribadi + pendidikan/pekerjaan --}}
            <div class="col-lg-8 mb-4">

                {{-- KARTU UTAMA: AKUN + DATA PRIBADI + PENDIDIKAN & PEKERJAAN --}}
                <form id="profileForm"
                      method="POST"
                      action="{{ route('ProfileUser.update') }}"
                      class="pe-card needs-validation"
                      novalidate>
                    @csrf
                    @method('PATCH')

                    {{-- HEADER CARD: ringkasan akun --}}
                    <div class="pe-card-header d-flex">
                        <div class="pe-avatar-wrapper">
                            <div class="pe-avatar-circle">
                                <span>{{ strtoupper(mb_substr($user->nama ?? $user->email, 0, 1)) }}</span>
                            </div>
                            <button type="button" class="btn btn-outline-gray btn-xs mt-2" disabled>
                                Ubah Gambar
                            </button>
                        </div>

                        <div class="pe-account-summary">
                            <div class="pe-section-label">Detail Akun</div>

                            <div class="row pe-row-gap">
                                <div class="col-md-3 col-sm-6">
                                    <label class="pe-label">Peran</label>
                                    <input type="text" class="form-control input-sm"
                                           value="{{ $user->role ?? 'asesi' }}" disabled>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <label class="pe-label">Nama Pengguna</label>
                                    <input type="text" class="form-control input-sm"
                                           value="{{ $user->nama ?? '-' }}" disabled>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <label class="pe-label">Email</label>
                                    <input type="email" class="form-control input-sm"
                                           value="{{ $user->email }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION: DATA PRIBADI --}}
                   {{-- SECTION: DATA PRIBADI - LAYOUT YANG DIPERBAIKI --}}
<div class="pe-section">
    <div class="pe-section-title">Data Pribadi</div>

    <div class="row pe-row-gap">
        {{-- Nama --}}
        <div class="col-md-4">
            <label class="form-label">
                Nama lengkap <span class="pe-required">*</span>
            </label>
            <input type="text"
                   name="nama"
                   class="form-control @error('nama') is-invalid @enderror"
                   value="{{ old('nama', $user->nama ?? ($pendaftaran->nama ?? '')) }}"
                   required>
            @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tempat Lahir --}}
        <div class="col-md-4">
            <label class="form-label">
                Tempat lahir <span class="pe-required">*</span>
            </label>
            <input type="text"
                   name="tempat_lahir"
                   class="form-control @error('tempat_lahir') is-invalid @enderror"
                   value="{{ old('tempat_lahir', $pendaftaran->tempat_lahir ?? '') }}"
                   required>
            @error('tempat_lahir')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tanggal Lahir --}}
        <div class="col-md-4">
            <label class="form-label">
                Tanggal lahir <span class="pe-required">*</span>
            </label>
            <input type="date"
                   name="tanggal_lahir"
                   class="form-control @error('tanggal_lahir') is-invalid @enderror"
                   value="{{ old(
                       'tanggal_lahir',
                       isset($pendaftaran->tanggal_lahir)
                           ? \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->format('Y-m-d')
                           : ''
                   ) }}"
                   required>
            @error('tanggal_lahir')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Jenis kelamin --}}
        <div class="col-md-4">
            <label class="form-label d-block">
                Jenis kelamin <span class="pe-required">*</span>
            </label>
            @php $jk = old('jenis_kelamin', $pendaftaran->jenis_kelamin ?? ''); @endphp
            <div class="pe-radio-group">
                <label class="pe-radio">
                    <input type="radio" name="jenis_kelamin" value="Laki-laki"
                           {{ $jk === 'Laki-laki' ? 'checked' : '' }} required>
                    <span>Laki-laki</span>
                </label>
                <label class="pe-radio">
                    <input type="radio" name="jenis_kelamin" value="Perempuan"
                           {{ $jk === 'Perempuan' ? 'checked' : '' }}>
                    <span>Perempuan</span>
                </label>
            </div>
            @error('jenis_kelamin')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- No KTP --}}
        <div class="col-md-4">
            <label class="form-label">
                NIK / No. KTP <span class="pe-required">*</span>
            </label>
            <input type="text"
                   name="no_ktp"
                   class="form-control @error('no_ktp') is-invalid @enderror"
                   value="{{ old('no_ktp', $pendaftaran->no_ktp ?? '') }}"
                   required>
            @error('no_ktp')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- No HP --}}
        <div class="col-md-4">
            <label class="form-label">
                No. Telp/Handphone <span class="pe-required">*</span>
            </label>
            <input type="text"
                   name="no_hp"
                   class="form-control @error('no_hp') is-invalid @enderror"
                   value="{{ old('no_hp', $user->no_hp ?? ($pendaftaran->no_hp ?? '')) }}"
                   required>
            @error('no_hp')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Kota --}}
        <div class="col-md-3">
            <label class="form-label">
                Kota/Kabupaten <span class="pe-required">*</span>
            </label>
            <input type="text"
                   name="kota"
                   class="form-control @error('kota') is-invalid @enderror"
                   value="{{ old('kota', $pendaftaran->kota ?? '') }}"
                   required>
            @error('kota')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Provinsi --}}
        <div class="col-md-3">
            <label class="form-label">
                Provinsi <span class="pe-required">*</span>
            </label>
            <input type="text"
                   name="provinsi"
                   class="form-control @error('provinsi') is-invalid @enderror"
                   value="{{ old('provinsi', $pendaftaran->provinsi ?? '') }}"
                   required>
            @error('provinsi')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Alamat - PINDAH KE KANAN --}}
        <div class="col-md-6">
            <label class="form-label">
                Alamat <span class="pe-required">*</span>
            </label>
            <textarea name="alamat"
                      class="form-control @error('alamat') is-invalid @enderror"
                      rows="2"
                      required>{{ old('alamat', $pendaftaran->alamat ?? '') }}</textarea>
            @error('alamat')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

                    {{-- SECTION: PENDIDIKAN & PEKERJAAN --}}
<div class="pe-section">
    <div class="pe-section-title">Pendidikan & Pekerjaan</div>

    <div class="row pe-row-gap">
        {{-- Pendidikan --}}
        <div class="col-md-4">
            <label class="form-label">
                Pendidikan terakhir <span class="pe-required">*</span>
            </label>
            @php
                $pendidikan = old('pendidikan', $pendaftaran->pendidikan ?? '');
            @endphp
            <select name="pendidikan"
                    class="form-control @error('pendidikan') is-invalid @enderror"
                    required>
                <option value="" {{ $pendidikan === '' ? 'selected' : '' }}>-- Pilih Pendidikan --</option>
                <option value="SMA/SMK" {{ $pendidikan === 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                <option value="D1" {{ $pendidikan === 'D1' ? 'selected' : '' }}>Diploma 1 (D1)</option>
                <option value="D2" {{ $pendidikan === 'D2' ? 'selected' : '' }}>Diploma 2 (D2)</option>
                <option value="D3" {{ $pendidikan === 'D3' ? 'selected' : '' }}>Diploma 3 (D3)</option>
                <option value="D4/S1" {{ $pendidikan === 'D4/S1' ? 'selected' : '' }}>Diploma 4 / Sarjana (D4/S1)</option>
                <option value="S2" {{ $pendidikan === 'S2' ? 'selected' : '' }}>Magister (S2)</option>
            </select>
            @error('pendidikan')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Pekerjaan --}}
        <div class="col-md-4">
            <label class="form-label">
                Pekerjaan <span class="pe-required">*</span>
            </label>
            <input type="text"
                   name="pekerjaan"
                   class="form-control @error('pekerjaan') is-invalid @enderror"
                   value="{{ old('pekerjaan', $pendaftaran->pekerjaan ?? '') }}"
                   placeholder="Contoh: Mahasiswa, Karyawan, Wiraswasta"
                   required>
            @error('pekerjaan')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Instansi --}}
        <div class="col-md-4">
            <label class="form-label">Instansi / Perusahaan (opsional)</label>
            <input type="text"
                   name="instansi"
                   class="form-control @error('instansi') is-invalid @enderror"
                   value="{{ old('instansi', $pendaftaran->instansi ?? '') }}"
                   placeholder="Nama instansi atau perusahaan">
            @error('instansi')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

                    <button type="submit" form="profileForm" class="btn btn-blue btn-sm">
                <i class="fa fa-save"></i> Simpan Profil
            </button>
                </form>
            </div>

            {{-- KOLOM KANAN: TANDA TANGAN + GANTI PASSWORD --}}
            <div class="col-lg-4 mb-4">

                {{-- KARTU: TANDA TANGAN DIGITAL --}}
                <div class="pe-card mb-4">
                    <div class="pe-section-title d-flex justify-content-between align-items-center">
                        <span>Tanda Tangan Digital</span>
                        <button type="button" class="btn btn-outline-gold btn-xs" id="btnOpenSignature">
                            Ubah Tanda Tangan
                        </button>
                    </div>

                    <p class="text-muted small mb-2">
                        Tanda tangan ini digunakan pada dokumen asesmen. Anda dapat mengganti dengan gambar baru
                        atau menggambar ulang secara digital.
                    </p>

                    @if (isset($pendaftaran) && !empty($pendaftaran->ttd_path))
                        <div class="pe-signature-preview">
                            <img src="{{ asset('storage/'.$pendaftaran->ttd_path) }}"
                                 alt="Tanda tangan saat ini">
                        </div>
                    @else
                        <div class="pe-signature-preview pe-signature-empty">
                            Belum ada tanda tangan tersimpan.
                        </div>
                    @endif

                    {{-- Form khusus tanda tangan --}}
                    <form id="signatureForm"
                          method="POST"
                          action="{{ route('ProfileUser.signature.update') }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        {{-- Upload file tanda tangan --}}
                        <div class="mb-2">
                            <label class="form-label">Upload gambar tanda tangan (JPG/PNG, maks. 2MB)</label>
                            <input type="file" name="ttd_file"
                                   class="form-control input-sm @error('ttd_file') is-invalid @enderror"
                                   accept=".jpg,.jpeg,.png">
                            @error('ttd_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Hidden input untuk hasil canvas --}}
                        <input type="hidden" name="ttd_digital" id="ttd_digital">

                        <button type="submit" class="btn btn-blue btn-sm w-100 mt-2">
                            Simpan Tanda Tangan
                        </button>
                    </form>
                </div>

                {{-- KARTU: GANTI PASSWORD --}}
                <div class="pe-card">
                    <div class="pe-section-title">Keamanan Akun</div>

                    {{-- Dokumentasi:
                         - Form ini mengirim ke route ProfileUser.password.update (PATCH)
                         - Password lama dicek, kemudian password baru di-hash dan disimpan di tabel users
                    --}}
                    <form method="POST"
                          action="{{ route('ProfileUser.password.update') }}"
                          class="needs-validation"
                          novalidate>
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label">
                                Password saat ini <span class="pe-required">*</span>
                            </label>
                            <input type="password"
                                   name="current_password"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   required>
                            @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Password baru <span class="pe-required">*</span>
                            </label>
                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   required>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Konfirmasi password baru <span class="pe-required">*</span>
                            </label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-blue btn-sm w-100">
                            <i class="fa fa-lock"></i> Ganti Password
                        </button>

                        <p class="text-muted small mt-2 mb-0">
                            Minimal 8 karakter. Gunakan kombinasi huruf besar, huruf kecil, dan angka
                            untuk keamanan yang lebih baik.
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </div>
</main>

{{-- MODAL TANDA TANGAN (CANVAS) --}}
<div class="pe-signature-backdrop" id="signatureBackdrop">
    <div class="pe-signature-modal">
        <div class="pe-signature-header">
            <span>Gambar Tanda Tangan</span>
            <button type="button" class="pe-close" id="btnCloseSignature">&times;</button>
        </div>
        <div class="pe-signature-body">
            {{-- id disamakan dengan halaman daftar --}}
            <canvas id="signature-canvas"></canvas>
        </div>
        <div class="pe-signature-footer">
            <button type="button" class="btn btn-outline-gray btn-sm" id="btnClearSignature">
                Bersihkan
            </button>
            <button type="button" class="btn btn-blue btn-sm" id="btnSaveSignature">
                Gunakan Tanda Tangan Ini
            </button>
        </div>
    </div>
</div>


{{-- jQuery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

{{-- Bootstrap 5 Bundle (includes Popper) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    // --- Validasi Bootstrap sederhana ---
    (function () {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();

    // --- Canvas Tanda Tangan Digital ---
    const backdrop   = document.getElementById('signatureBackdrop');
    const btnOpen    = document.getElementById('btnOpenSignature');
    const btnClose   = document.getElementById('btnCloseSignature');
    const btnClear   = document.getElementById('btnClearSignature');
    const btnSave    = document.getElementById('btnSaveSignature');
    const canvas     = document.getElementById('signature-canvas');
    const ttdField   = document.getElementById('ttd_digital');

    let ctx, drawing = false, lastPos = {x:0,y:0};

    function initCanvas() {
        if (!canvas) return;

        const parent = canvas.parentElement;
        const width  = parent ? parent.clientWidth : 500;

        canvas.width  = width;
        canvas.height = 200;

        ctx = canvas.getContext('2d');
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.lineWidth = 2;
        ctx.strokeStyle = '#000';
        ctx.lineCap = 'round';
    }

    function getPos(e) {
        const rect = canvas.getBoundingClientRect();
        if (e.touches && e.touches.length > 0) {
            return {
                x: e.touches[0].clientX - rect.left,
                y: e.touches[0].clientY - rect.top
            };
        }
        return {
            x: e.clientX - rect.left,
            y: e.clientY - rect.top
        };
    }

    function startDraw(e) {
        drawing = true;
        lastPos = getPos(e);
        e.preventDefault();
    }

    function draw(e) {
        if (!drawing) return;
        const pos = getPos(e);
        ctx.beginPath();
        ctx.moveTo(lastPos.x, lastPos.y);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
        lastPos = pos;
        e.preventDefault();
    }

    function endDraw(e) {
        drawing = false;
        if (e) e.preventDefault();
    }

    if (btnOpen) {
        btnOpen.addEventListener('click', () => {
            backdrop.style.display = 'flex';
            setTimeout(initCanvas, 30);
        });
    }

    if (btnClose) {
        btnClose.addEventListener('click', () => {
            backdrop.style.display = 'none';
        });
    }

    if (btnClear) {
        btnClear.addEventListener('click', () => initCanvas());
    }

    if (btnSave) {
        btnSave.addEventListener('click', () => {
            if (!canvas) return;
            const dataUrl = canvas.toDataURL('image/png'); // "data:image/png;base64,..."
            if (ttdField) {
                ttdField.value = dataUrl;
            }
            backdrop.style.display = 'none';
            alert('Tanda tangan tersimpan. Jangan lupa klik tombol "Simpan Tanda Tangan".');
        });
    }

    if (canvas) {
        // mouse
        canvas.addEventListener('mousedown', startDraw);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', endDraw);
        canvas.addEventListener('mouseleave', endDraw);

        // touch
        canvas.addEventListener('touchstart', startDraw, {passive:false});
        canvas.addEventListener('touchmove', draw, {passive:false});
        canvas.addEventListener('touchend', endDraw);
        canvas.addEventListener('touchcancel', endDraw);
    }
</script>

</body>
</html>
