{{-- resources/views/pengajuan/create.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Pengajuan Skema - {{ $program->nama }}</title>

  {{-- Bootstrap CSS --}}
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  {{-- Bootstrap Icon --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  {{-- Custom CSS --}}
  <link rel="stylesheet" href="{{ asset('css/pengajuan.css') }}">
</head>
<body>
<div class="container py-5">

  {{-- FLASH ERROR (opsional) --}}
  @if (session('error'))
    <div class="alert alert-danger">
      <strong>Gagal:</strong> {{ session('error') }}
    </div>
  @endif

  {{-- VALIDATION ERROR --}}
  @if ($errors->any())
    <div class="alert alert-danger">
      <strong>Terjadi kesalahan:</strong>
      <ul class="mb-0">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Header --}}
  <div class="text-center mb-5">
    <h2 class="fw-bold">Pengajuan Skema Sertifikasi</h2>
    <p class="text-muted">{{ $program->nama }}</p>
  </div>

  {{-- Progress --}}
  <div class="wizard-progress">
    <div class="step active" data-step="1">
      <div class="step-number">1</div>
      <div class="step-label">Data Pribadi</div>
    </div>
    <div class="step-divider"></div>
    <div class="step" data-step="2">
      <div class="step-number">2</div>
      <div class="step-label">Bukti & Dokumen</div>
    </div>
    <div class="step-divider"></div>
    <div class="step" data-step="3">
      <div class="step-number">3</div>
      <div class="step-label">Self Assessment</div>
    </div>
    <div class="step-divider"></div>
    <div class="step" data-step="4">
      <div class="step-number">4</div>
      <div class="step-label">Review & Submit</div>
    </div>
  </div>

  {{-- FORM --}}
  <form id="formPengajuan"
        method="POST"
        action="{{ route('pengajuan.store') }}"
        enctype="multipart/form-data"
        novalidate>
    @csrf

    {{-- penting: agar balik ke step terakhir saat validation error --}}
    <input type="hidden" name="current_step" id="current_step" value="{{ old('current_step', 1) }}">
    <input type="hidden" name="program_pelatihan_id" value="{{ $program->id }}">

    {{-- =========================
         STEP 1: APL-01 DATA PRIBADI
    ========================== --}}
    <div class="step-content active" id="step-1">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">
            <i class="bi bi-person-fill"></i> APL-01: Data Pribadi
          </h5>
        </div>

        <div class="card-body">
          <h6 class="fw-bold mb-3">A. Data Pribadi</h6>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
              <input type="text"
                     class="form-control"
                     name="nama_lengkap"
                     required
                     value="{{ old('nama_lengkap', auth()->user()->nama ?? auth()->user()->name ?? '') }}">
            </div>

            <div class="col-md-6">
              <label class="form-label">NIK <span class="text-danger">*</span></label>
              <input type="text"
                     class="form-control"
                     name="nik"
                     maxlength="16"
                     required
                     value="{{ old('nik') }}">
            </div>

            <div class="col-md-6">
              <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
              <input type="text"
                     class="form-control"
                     name="tempat_lahir"
                     required
                     value="{{ old('tempat_lahir') }}">
            </div>

            <div class="col-md-6">
              <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
              <input type="date"
                     class="form-control"
                     name="tanggal_lahir"
                     required
                     value="{{ old('tanggal_lahir') }}">
            </div>

            <div class="col-md-6">
              <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
              <select class="form-select" name="jenis_kelamin" required>
                <option value="">Pilih</option>
                <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Kebangsaan</label>
              <input type="text"
                     class="form-control"
                     name="kebangsaan"
                     value="{{ old('kebangsaan', 'Indonesia') }}">
            </div>

            <div class="col-md-8">
              <label class="form-label">Alamat Rumah <span class="text-danger">*</span></label>
              <textarea class="form-control"
                        name="alamat_rumah"
                        rows="2"
                        required>{{ old('alamat_rumah') }}</textarea>
            </div>

            <div class="col-md-4">
              <label class="form-label">Kode Pos</label>
              <input type="text"
                     class="form-control"
                     name="kode_pos"
                     maxlength="10"
                     value="{{ old('kode_pos') }}">
            </div>

            <div class="col-md-4">
              <label class="form-label">Telepon Rumah</label>
              <input type="text"
                     class="form-control"
                     name="telepon_rumah"
                     value="{{ old('telepon_rumah') }}">
            </div>

            <div class="col-md-4">
              <label class="form-label">No. HP <span class="text-danger">*</span></label>
              <input type="text"
                     class="form-control"
                     name="hp"
                     required
                     value="{{ old('hp', auth()->user()->no_hp ?? '') }}">
            </div>

            <div class="col-md-4">
              <label class="form-label">Email <span class="text-danger">*</span></label>
              <input type="email"
                     class="form-control"
                     name="email"
                     required
                     value="{{ old('email', auth()->user()->email ?? '') }}">
            </div>
          </div>

          <hr class="my-4">

          <h6 class="fw-bold mb-3">B. Detail Pendidikan</h6>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Pendidikan Terakhir</label>
              <select class="form-select" name="kualifikasi_pendidikan">
                <option value="">Pilih Pendidikan</option>
                @php $oldP = old('kualifikasi_pendidikan'); @endphp
                @foreach(['SD','SMP','SMA/SMK','D1','D2','D3','S1','S2','S3'] as $opt)
                  <option value="{{ $opt }}" {{ $oldP === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <hr class="my-4">

          <h6 class="fw-bold mb-3">C. Detail Pekerjaan</h6>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Pekerjaan <span class="text-danger">*</span></label>
              <select class="form-select" name="pekerjaan" required>
                @php $oldKerja = old('pekerjaan'); @endphp
                <option value="">Pilih Pekerjaan</option>
                @foreach([
                  'Belum/Tidak Bekerja',
                  'Mengurus Rumah Tangga',
                  'Pelajar/Mahasiswa',
                  'Pensiunan',
                  'Pegawai Negeri Sipil (PNS)',
                  'Tentara Nasional Indonesia (TNI)',
                  'Kepolisian RI (POLRI)',
                  'Karyawan Swasta',
                  'Karyawan BUMN',
                  'Karyawan BUMD',
                  'Wiraswasta',
                  'Lainnya'
                ] as $job)
                  <option value="{{ $job }}" {{ $oldKerja === $job ? 'selected' : '' }}>{{ $job }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Institusi/Perusahaan</label>
              <input type="text" class="form-control" name="nama_institusi" value="{{ old('nama_institusi') }}">
            </div>

            <div class="col-md-6">
              <label class="form-label">Jabatan</label>
              <input type="text" class="form-control" name="jabatan" value="{{ old('jabatan') }}">
            </div>

            <div class="col-md-6">
              <label class="form-label">Email Institusi/Perusahaan</label>
              <input type="email" class="form-control" name="email_kantor" value="{{ old('email_kantor') }}">
            </div>

            <div class="col-md-8">
              <label class="form-label">Alamat Institusi/Perusahaan</label>
              <textarea class="form-control" name="alamat_kantor" rows="2">{{ old('alamat_kantor') }}</textarea>
            </div>

            <div class="col-md-4">
              <label class="form-label">Kode Pos Institusi/Perusahaan</label>
              <input type="text" class="form-control" name="kode_pos_kantor" maxlength="10" value="{{ old('kode_pos_kantor') }}">
            </div>

            <div class="col-md-6">
              <label class="form-label">Nomor Telepon Institusi/Perusahaan</label>
              <input type="text" class="form-control" name="telepon_kantor" value="{{ old('telepon_kantor') }}">
            </div>

            <div class="col-md-6">
              <label class="form-label">Fax Institusi/Perusahaan</label>
              <input type="text" class="form-control" name="fax" value="{{ old('fax') }}">
            </div>
          </div>

          <hr class="my-4">

          <h6 class="fw-bold mb-3">D. Sertifikat yang Pernah Dimiliki (Jika Ada)</h6>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nama Sertifikat</label>
              <input type="text" class="form-control" name="nama_sertifikat" value="{{ old('nama_sertifikat') }}">
            </div>
            <div class="col-md-6">
              <label class="form-label">Nomor Sertifikat</label>
              <input type="text" class="form-control" name="nomor_sertifikat" value="{{ old('nomor_sertifikat') }}">
            </div>
          </div>

        </div>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('pengajuan.pilih-skema') }}" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="button" class="btn btn-primary btn-next">
          Selanjutnya <i class="bi bi-arrow-right"></i>
        </button>
      </div>
    </div>

    {{-- =========================
         STEP 2: BUKTI & DOKUMEN
    ========================== --}}
    <div class="step-content" id="step-2" style="display:none;">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0"><i class="bi bi-file-earmark-text"></i> APL-01: Bukti & Dokumen</h5>
        </div>

        <div class="card-body">
          <h6 class="fw-bold mb-3">A. Tujuan Asesmen</h6>
          @php $oldTujuan = old('tujuan_asesmen', []); @endphp

          <div class="mb-3">
            @foreach([
              'PKT' => 'Peserta Kursus/Pelatihan (PKT)',
              'RPL' => 'Rekognisi Pembelajaran Lampau (RPL)',
              'RCC' => 'Recognition of Current Competency (RCC)',
              'Lainnya' => 'Lainnya'
            ] as $val => $label)
              <div class="form-check">
                <input class="form-check-input"
                       type="checkbox"
                       name="tujuan_asesmen[]"
                       value="{{ $val }}"
                       id="tujuan_{{ strtolower($val) }}"
                       {{ in_array($val, $oldTujuan) ? 'checked' : '' }}>
                <label class="form-check-label" for="tujuan_{{ strtolower($val) }}">
                  {{ $label }}
                </label>
              </div>
            @endforeach
          </div>

          <hr class="my-4">

          <h6 class="fw-bold mb-3">B. Bukti Kelengkapan Persyaratan Dasar</h6>
          <div class="mb-3">
            <label class="form-label">Pilih bukti yang akan diserahkan:</label>
            <textarea class="form-control"
                      name="bukti_penyertaan_dasar"
                      rows="3"
                      placeholder="Contoh: Fotokopi KTP, Pas Foto, dll">{{ old('bukti_penyertaan_dasar') }}</textarea>
          </div>

          <h6 class="fw-bold mb-3">C. Bukti Administrasif</h6>
          <div class="mb-3">
            <label class="form-label">Dokumen administrasi pendukung:</label>
            <textarea class="form-control"
                      name="bukti_administrasif"
                      rows="3"
                      placeholder="Contoh: Ijazah, Transkrip Nilai, Sertifikat, dll">{{ old('bukti_administrasif') }}</textarea>
          </div>

          <hr class="my-4">

          <h6 class="fw-bold mb-3">D. Upload Dokumen Pendukung</h6>
          <div class="mb-3">
            <p class="text-muted small mb-2">
              Upload dokumen pendukung (KTP, Ijazah, Sertifikat, Portfolio, CV, dll).
              Format: PDF, JPG, PNG, DOC, DOCX. Maks 2MB per file.
              <br><b>Catatan:</b> jika validasi gagal, file harus dipilih ulang.
            </p>

            @php
              $oldJenis = old('jenis_dokumen', ['ktp']); // minimal 1 baris
              if (!is_array($oldJenis) || count($oldJenis) === 0) $oldJenis = ['ktp'];
            @endphp

            <div id="dokumen-container">
              @foreach($oldJenis as $idx => $j)
                <div class="dokumen-item mb-3">
                  <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                      <select class="form-select" name="jenis_dokumen[]">
                        <option value="ktp" {{ $j==='ktp'?'selected':'' }}>KTP</option>
                        <option value="ijazah" {{ $j==='ijazah'?'selected':'' }}>Ijazah</option>
                        <option value="sertifikat" {{ $j==='sertifikat'?'selected':'' }}>Sertifikat</option>
                        <option value="cv" {{ $j==='cv'?'selected':'' }}>CV</option>
                        <option value="portfolio" {{ $j==='portfolio'?'selected':'' }}>Portfolio</option>
                        <option value="foto" {{ $j==='foto'?'selected':'' }}>Foto</option>
                        <option value="lainnya" {{ $j==='lainnya'?'selected':'' }}>Lainnya</option>
                      </select>
                    </div>

                    <div class="col-md-8">
                      <input type="file"
                             class="form-control"
                             name="dokumen[]"
                             accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                    </div>
                  </div>

                  {{-- tombol hapus baris dokumen --}}
                  @if($idx > 0)
                    <div class="mt-2">
                      <button type="button" class="btn btn-sm btn-danger btn-remove-dokumen">
                        <i class="bi bi-trash"></i> Hapus Baris
                      </button>
                    </div>
                  @endif
                </div>
              @endforeach
            </div>

            <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-dokumen">
              <i class="bi bi-plus-circle"></i> Tambah Dokumen
            </button>
          </div>

          <div class="mb-3">
            <label class="form-label">Catatan Tambahan (Opsional)</label>
            <textarea class="form-control"
                      name="catatan"
                      rows="3"
                      placeholder="Tuliskan catatan atau informasi tambahan jika ada">{{ old('catatan') }}</textarea>
          </div>

        </div>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <button type="button" class="btn btn-secondary btn-prev">
          <i class="bi bi-arrow-left"></i> Sebelumnya
        </button>
        <button type="button" class="btn btn-primary btn-next">
          Selanjutnya <i class="bi bi-arrow-right"></i>
        </button>
      </div>
    </div>

    {{-- =========================
         STEP 3: APL-02 SELF ASSESSMENT + PORTFOLIO
    ========================== --}}
    <div class="step-content" id="step-3" style="display:none;">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0"><i class="bi bi-clipboard-check"></i> APL-02: Asesmen Mandiri & Portfolio</h5>
        </div>

        <div class="card-body">
          <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            <strong>Petunjuk:</strong><br>
            • Pilih <strong>K</strong> jika Anda sudah menguasai elemen ini<br>
            • Pilih <strong>BK</strong> jika Anda belum menguasai<br>
            • Upload <strong>portfolio/bukti</strong> yang relevan (jika ada)
          </div>

          @if($program->units && $program->units->count() > 0)
            @foreach($program->units as $index => $unit)
              <div class="unit-assessment-card mb-4">
                <div class="unit-header">
                  <h6 class="fw-bold mb-2">
                    <i class="bi bi-check2-square text-primary"></i>
                    {{ $index + 1 }}. {{ $unit->judul_unit }}
                  </h6>
                  <p class="small text-muted mb-3">Kode Unit: {{ $unit->kode_unit }}</p>
                </div>

                {{-- Table --}}
                <div class="table-responsive mb-3">
                  <table class="table table-bordered table-sm assessment-table">
                    <thead class="table-light">
                    <tr>
                      <th width="70%">Elemen Kompetensi</th>
                      <th width="15%" class="text-center">K</th>
                      <th width="15%" class="text-center">BK</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($unit->elemenKompetensis && $unit->elemenKompetensis->count() > 0)
                      @foreach($unit->elemenKompetensis as $elemenIndex => $elemen)
                        @php $oldStatus = old("self_assessment.{$unit->id}.{$elemen->id}.status"); @endphp
                        <tr>
                          <td>Elemen {{ $elemen->no_urut }} - {{ $elemen->nama_elemen }}</td>

                          <td class="text-center">
                            <input type="radio"
                                   class="form-check-input"
                                   name="self_assessment[{{ $unit->id }}][{{ $elemen->id }}][status]"
                                   value="K"
                                   {{ $oldStatus === 'K' ? 'checked' : '' }}>
                          </td>

                          <td class="text-center">
                            <input type="radio"
                                   class="form-check-input"
                                   name="self_assessment[{{ $unit->id }}][{{ $elemen->id }}][status]"
                                   value="BK"
                                   {{ $oldStatus === 'BK' ? 'checked' : '' }}>
                          </td>
                        </tr>
                      @endforeach
                    @else
                      @for($i=1; $i<=3; $i++)
                        @php $oldStatus = old("self_assessment.{$unit->id}.{$i}.status"); @endphp
                        <tr>
                          <td>Elemen {{ $i }} - {{ $unit->judul_unit }}</td>

                          <td class="text-center">
                            <input type="radio"
                                   class="form-check-input"
                                   name="self_assessment[{{ $unit->id }}][{{ $i }}][status]"
                                   value="K"
                                   {{ $oldStatus === 'K' ? 'checked' : '' }}>
                          </td>

                          <td class="text-center">
                            <input type="radio"
                                   class="form-check-input"
                                   name="self_assessment[{{ $unit->id }}][{{ $i }}][status]"
                                   value="BK"
                                   {{ $oldStatus === 'BK' ? 'checked' : '' }}>
                          </td>
                        </tr>
                      @endfor
                    @endif
                    </tbody>
                  </table>
                </div>

                {{-- Upload Bukti Portfolio --}}
                <div class="mb-3">
                  <label class="form-label fw-bold">
                    <i class="bi bi-upload"></i> Upload Bukti Portfolio
                  </label>
                  <input type="file"
                         class="form-control"
                         name="portfolio[{{ $unit->id }}][]"
                         accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                         multiple>
                  <small class="text-muted">
                    Format: PDF, JPG, PNG, DOC, DOCX. Maks 2MB per file. Boleh upload lebih dari satu file.
                  </small>
                </div>

                {{-- Deskripsi Bukti --}}
                <div class="mb-3">
                  <label class="form-label">Deskripsi Bukti (opsional)</label>
                  <textarea class="form-control"
                            name="portfolio_deskripsi[{{ $unit->id }}][]"
                            rows="2"
                            placeholder="Jelaskan bukti yang Anda upload...">{{ old("portfolio_deskripsi.{$unit->id}.0", '') }}</textarea>
                </div>

                <hr class="my-4">
              </div>
            @endforeach
          @else
            <div class="alert alert-warning">
              <i class="bi bi-exclamation-triangle"></i> Tidak ada unit kompetensi untuk skema ini.
            </div>
          @endif
        </div>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <button type="button" class="btn btn-secondary btn-prev">
          <i class="bi bi-arrow-left"></i> Sebelumnya
        </button>
        <button type="button" class="btn btn-primary btn-next">
          Selanjutnya <i class="bi bi-arrow-right"></i>
        </button>
      </div>
    </div>

    {{-- =========================
         STEP 4: REVIEW & SUBMIT
    ========================== --}}
    <div class="step-content" id="step-4" style="display:none;">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0"><i class="bi bi-check-circle"></i> Review & Submit</h5>
        </div>

        <div class="card-body">
          <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            Pastikan semua data yang Anda isi sudah benar sebelum mengirimkan pengajuan.
          </div>

          <div id="review-summary"></div>

          <hr class="my-4">

          <h6 class="fw-bold mb-3">Tanda Tangan Digital</h6>
          <input type="hidden" name="ttd_digital" id="ttd_digital" value="{{ old('ttd_digital') }}">

          <div class="mb-3">
            <button class="btn btn-outline-primary" id="open-signature-modal" type="button">
              <i class="bi bi-pen"></i> Buat Tanda Tangan
            </button>
            <small class="text-muted ms-2">
              Anda dapat menggambar langsung atau mengunggah gambar tanda tangan.
            </small>
          </div>

          <div id="signature-preview" style="display:none;">
            <p class="mb-1 small fw-bold">Preview tanda tangan:</p>
            <div class="border rounded p-2 bg-white" style="max-width:300px;">
              <img id="signature-preview-img" class="img-fluid" alt="Preview TTD">
            </div>
          </div>

          <hr class="my-4">

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="agree" name="agree" required {{ old('agree') ? 'checked' : '' }}>
            <label class="form-check-label" for="agree">
              Saya menyatakan bahwa seluruh data yang saya isi adalah benar dan saya menyetujui syarat & ketentuan yang berlaku.
            </label>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <button type="button" class="btn btn-secondary btn-prev">
          <i class="bi bi-arrow-left"></i> Sebelumnya
        </button>
        <button type="submit" class="btn btn-success btn-lg" id="btnSubmit">
          <i class="bi bi-send"></i> Kirim Pengajuan
        </button>
      </div>
    </div>

  </form>

  {{-- Auto-save indicator --}}
  <div class="auto-save-indicator" id="auto-save-indicator">
    <i class="bi bi-cloud-check"></i> Draft tersimpan otomatis
  </div>

</div>

{{-- =========================
     MODAL TANDA TANGAN
========================== --}}
<div class="signature-modal-backdrop" id="signature-modal-backdrop">
  <div class="signature-modal">
    <div class="signature-modal-header">
      <span>Tanda Tangan Digital</span>
      <button type="button" class="close-signature-modal" aria-label="Close">&times;</button>
    </div>

    <div class="signature-modal-body">
      <p class="mb-2" style="font-size: 13px;">
        Gunakan mouse / touchscreen untuk menggambar tanda tangan Anda pada area berikut:
      </p>
      <div class="signature-pad">
        <canvas id="signature-canvas" width="600" height="200"></canvas>
      </div>
    </div>

    <div class="signature-modal-footer">
      <button class="btn btn-light" id="btn-signature-cancel" type="button">Batal</button>
      <button class="btn btn-danger" id="btn-signature-clear" type="button">Hapus</button>

      <label class="btn btn-success mb-0">
        Upload Gambar
        <input type="file" id="signature-upload" accept=".jpg,.jpeg,.png" style="display:none;">
      </label>

      <button class="btn btn-primary" id="btn-signature-save" type="button">
        Simpan Tanda Tangan
      </button>
    </div>
  </div>
</div>

{{-- Scripts --}}
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/pengajuan-wizard.js') }}"></script>

{{-- Patch tambahan agar: step balik sesuai old, remove baris dokumen/portfolio aman --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  // 1) Buka step terakhir (jika pengajuan gagal validasi)
  const lastStep = {{ (int) old('current_step', 1) }};
  if (window.goToStep) window.goToStep(lastStep);

  // 2) Hapus baris dokumen (delegation)
  document.addEventListener('click', function(e){
    const btn = e.target.closest('.btn-remove-dokumen');
    if(btn){
      const item = btn.closest('.dokumen-item');
      if(item) item.remove();
    }
  });
});
</script>

</body>
</html>
