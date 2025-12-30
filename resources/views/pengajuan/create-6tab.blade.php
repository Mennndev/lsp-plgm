{{-- resources/views/pengajuan/create-6tab.blade.php --}}
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
  <link rel="stylesheet" href="{{ asset('css/pengajuan-6tab.css') }}">
</head>
<body>
<div class="container py-5">

  {{-- FLASH ERROR --}}
  @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
      <strong>Gagal:</strong> {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- VALIDATION ERROR --}}
  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
      <strong>Terjadi kesalahan:</strong>
      <ul class="mb-0">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- Header --}}
  <div class="text-center mb-4">
    <h2 class="fw-bold">Pengajuan Skema Sertifikasi</h2>
    <p class="text-muted">{{ $program->nama }}</p>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb justify-content-center">
        <li class="breadcrumb-item"><a href="{{ route('dashboard.user') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('pengajuan.pilih-skema') }}">Pilih Skema</a></li>
        <li class="breadcrumb-item active">Pengajuan</li>
      </ol>
    </nav>
  </div>

  {{-- Tab Navigation --}}
  <div class="tab-navigation" id="tabNavigation">
    <div class="tab-item active" data-tab="1">
      <span class="tab-number">1</span>
      <span class="tab-label">Data Pribadi</span>
    </div>
    <div class="tab-item" data-tab="2">
      <span class="tab-number">2</span>
      <span class="tab-label">Persyaratan Dasar</span>
    </div>
    <div class="tab-item" data-tab="3">
      <span class="tab-number">3</span>
      <span class="tab-label">Bukti Administratif</span>
    </div>
    <div class="tab-item" data-tab="4">
      <span class="tab-number">4</span>
      <span class="tab-label">Bukti Portofolio</span>
    </div>
    <div class="tab-item" data-tab="5">
      <span class="tab-number">5</span>
      <span class="tab-label">Bukti Kompetensi</span>
    </div>
    <div class="tab-item" data-tab="6">
      <span class="tab-number">6</span>
      <span class="tab-label">Review & Submit</span>
    </div>
  </div>

  {{-- FORM --}}
  <form id="formPengajuan"
        method="POST"
        action="{{ route('pengajuan.store') }}"
        enctype="multipart/form-data"
        novalidate>
    @csrf

    <input type="hidden" name="current_tab" id="current_tab" value="{{ old('current_tab', 1) }}">
    <input type="hidden" name="program_pelatihan_id" value="{{ $program->id }}">

    {{-- TAB 1: DATA PRIBADI --}}
    <div class="tab-content-item active" id="tab-1">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">
            <i class="bi bi-person-fill"></i> Tab 1: Data Pribadi (APL-01)
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
              <label class="form-label">No. HP <span class="text-danger">*</span></label>
              <input type="text"
                     class="form-control"
                     name="hp"
                     required
                     value="{{ old('hp', auth()->user()->no_hp ?? '') }}">
            </div>

            <div class="col-md-4">
              <label class="form-label">Telepon Rumah</label>
              <input type="text"
                     class="form-control"
                     name="telepon_rumah"
                     value="{{ old('telepon_rumah') }}">
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
              <label class="form-label">Telepon Institusi/Perusahaan</label>
              <input type="text" class="form-control" name="telepon_kantor" value="{{ old('telepon_kantor') }}">
            </div>
          </div>

          <hr class="my-4">

          <h6 class="fw-bold mb-3">D. Tujuan Asesmen</h6>
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
        </div>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('pengajuan.pilih-skema') }}" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="button" class="btn btn-primary btn-next-tab">
          Selanjutnya <i class="bi bi-arrow-right"></i>
        </button>
      </div>
    </div>

    {{-- TAB 2: PERSYARATAN DASAR --}}
    <div class="tab-content-item" id="tab-2">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">
            <i class="bi bi-file-earmark-check"></i> Tab 2: Persyaratan Dasar
          </h5>
        </div>

        <div class="card-body">
          <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            <strong>Petunjuk:</strong> Silakan lampirkan file untuk setiap persyaratan yang diminta. 
            File dengan tanda <span class="text-danger">*</span> adalah wajib diisi.
          </div>

          @if($program->persyaratanDasar && $program->persyaratanDasar->count() > 0)
            <table class="table table-bordered persyaratan-table">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th width="50%">Nama Dokumen</th>
                  <th width="20%" class="text-center">Wajib</th>
                  <th width="25%" class="text-center">Lampiran</th>
                </tr>
              </thead>
              <tbody>
                @foreach($program->persyaratanDasar as $index => $persyaratan)
                  <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                      <span class="doc-name">{{ $persyaratan->nama_dokumen }}</span>
                      @if($persyaratan->is_wajib)
                        <span class="text-danger">*</span>
                      @endif
                      <span class="info-badge">
                        <i class="bi bi-info-circle"></i> Akan ditampilkan pada Form APL-01
                      </span>
                    </td>
                    <td class="text-center">
                      @if($persyaratan->is_wajib)
                        <span class="badge bg-danger">Wajib</span>
                      @else
                        <span class="badge bg-secondary">Opsional</span>
                      @endif
                    </td>
                    <td class="text-center">
                      <input type="file"
                             class="form-control form-control-sm"
                             name="persyaratan_dasar[{{ $persyaratan->id }}]"
                             accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                             {{ $persyaratan->is_wajib ? 'required' : '' }}>
                      <small class="text-muted">Max 2MB (PDF, JPG, PNG, DOC, DOCX)</small>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @else
            <div class="alert alert-warning">
              <i class="bi bi-exclamation-triangle"></i> 
              Tidak ada persyaratan dasar untuk skema ini. Silakan lanjutkan ke tab berikutnya.
            </div>
          @endif
        </div>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <button type="button" class="btn btn-secondary btn-prev-tab">
          <i class="bi bi-arrow-left"></i> Sebelumnya
        </button>
        <button type="button" class="btn btn-primary btn-next-tab">
          Selanjutnya <i class="bi bi-arrow-right"></i>
        </button>
      </div>
    </div>

    {{-- TAB 3: BUKTI ADMINISTRATIF --}}
    <div class="tab-content-item" id="tab-3">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">
            <i class="bi bi-file-earmark-person"></i> Tab 3: Bukti Administratif
          </h5>
        </div>

        <div class="card-body">
          <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            <strong>Petunjuk:</strong> Lampirkan dokumen administratif seperti Copy KTP, Pas Foto, dll.
          </div>

          @if($program->buktiAdministratif && $program->buktiAdministratif->count() > 0)
            <table class="table table-bordered persyaratan-table">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th width="50%">Nama Dokumen</th>
                  <th width="20%" class="text-center">Wajib</th>
                  <th width="25%" class="text-center">Lampiran</th>
                </tr>
              </thead>
              <tbody>
                @foreach($program->buktiAdministratif as $index => $bukti)
                  <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                      <span class="doc-name">{{ $bukti->nama_dokumen }}</span>
                      @if($bukti->is_wajib)
                        <span class="text-danger">*</span>
                      @endif
                      <span class="info-badge">
                        <i class="bi bi-info-circle"></i> Akan ditampilkan pada Form APL-01
                      </span>
                    </td>
                    <td class="text-center">
                      @if($bukti->is_wajib)
                        <span class="badge bg-danger">Wajib</span>
                      @else
                        <span class="badge bg-secondary">Opsional</span>
                      @endif
                    </td>
                    <td class="text-center">
                      <input type="file"
                             class="form-control form-control-sm"
                             name="bukti_administratif[{{ $bukti->id }}]"
                             accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                             {{ $bukti->is_wajib ? 'required' : '' }}>
                      <small class="text-muted">Max 2MB (PDF, JPG, PNG, DOC, DOCX)</small>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @else
            <div class="alert alert-warning">
              <i class="bi bi-exclamation-triangle"></i> 
              Tidak ada bukti administratif untuk skema ini. Silakan lanjutkan ke tab berikutnya.
            </div>
          @endif
        </div>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <button type="button" class="btn btn-secondary btn-prev-tab">
          <i class="bi bi-arrow-left"></i> Sebelumnya
        </button>
        <button type="button" class="btn btn-primary btn-next-tab">
          Selanjutnya <i class="bi bi-arrow-right"></i>
        </button>
      </div>
    </div>

    {{-- TAB 4: BUKTI PORTOFOLIO --}}
    <div class="tab-content-item" id="tab-4">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">
            <i class="bi bi-folder"></i> Tab 4: Bukti Portofolio
          </h5>
        </div>

        <div class="card-body">
          <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            <strong>Petunjuk:</strong> Lampirkan dokumen portofolio seperti Surat Keterangan Kerja, Sertifikat Pelatihan, Ijazah, dll.
          </div>

          @if($program->buktiPortofolioTemplate && $program->buktiPortofolioTemplate->count() > 0)
            <table class="table table-bordered persyaratan-table">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th width="50%">Nama Dokumen</th>
                  <th width="20%" class="text-center">Wajib</th>
                  <th width="25%" class="text-center">Lampiran</th>
                </tr>
              </thead>
              <tbody>
                @foreach($program->buktiPortofolioTemplate as $index => $portofolio)
                  <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                      <span class="doc-name">{{ $portofolio->nama_dokumen }}</span>
                      @if($portofolio->is_wajib)
                        <span class="text-danger">*</span>
                      @endif
                      <span class="info-badge">
                        <i class="bi bi-info-circle"></i> Akan ditampilkan pada Form APL-02
                      </span>
                    </td>
                    <td class="text-center">
                      @if($portofolio->is_wajib)
                        <span class="badge bg-danger">Wajib</span>
                      @else
                        <span class="badge bg-secondary">Opsional</span>
                      @endif
                    </td>
                    <td class="text-center">
                      <input type="file"
                             class="form-control form-control-sm"
                             name="bukti_portofolio[{{ $portofolio->id }}]"
                             accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                             {{ $portofolio->is_wajib ? 'required' : '' }}>
                      <small class="text-muted">Max 2MB (PDF, JPG, PNG, DOC, DOCX)</small>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @else
            <div class="alert alert-warning">
              <i class="bi bi-exclamation-triangle"></i> 
              Tidak ada bukti portofolio untuk skema ini. Silakan lanjutkan ke tab berikutnya.
            </div>
          @endif
        </div>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <button type="button" class="btn btn-secondary btn-prev-tab">
          <i class="bi bi-arrow-left"></i> Sebelumnya
        </button>
        <button type="button" class="btn btn-primary btn-next-tab">
          Selanjutnya <i class="bi bi-arrow-right"></i>
        </button>
      </div>
    </div>

    {{-- TAB 5: BUKTI KOMPETENSI --}}
    <div class="tab-content-item" id="tab-5">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">
            <i class="bi bi-clipboard-check"></i> Tab 5: Bukti Kompetensi (Self Assessment & Upload)
          </h5>
        </div>

        <div class="card-body">
          <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            <strong>Petunjuk:</strong><br>
            • Pilih <strong>K</strong> jika Anda sudah menguasai kriteria ini<br>
            • Pilih <strong>BK</strong> jika Anda belum menguasai<br>
            • Upload <strong>bukti kompetensi</strong> untuk setiap Kriteria Unjuk Kerja (KUK)
          </div>

          @if($program->units && $program->units->count() > 0)
            @foreach($program->units as $unitIndex => $unit)
              <div class="unit-assessment-card mb-4">
                <div class="unit-header">
                  <h6 class="fw-bold mb-2">
                    <i class="bi bi-check2-square text-primary"></i>
                    {{ $unitIndex + 1 }}. {{ $unit->judul_unit }}
                  </h6>
                  <p class="small text-muted mb-3">Kode Unit: {{ $unit->kode_unit }}</p>
                </div>

                @if($unit->elemenKompetensis && $unit->elemenKompetensis->count() > 0)
                  @foreach($unit->elemenKompetensis as $elemenIndex => $elemen)
                    <div class="mb-4">
                      <h6 class="fw-bold text-primary">
                        Elemen {{ $elemen->no_urut }}: {{ $elemen->nama_elemen }}
                      </h6>

                      @if($elemen->kriteriaUnjukKerja && $elemen->kriteriaUnjukKerja->count() > 0)
                        <table class="table table-bordered table-sm">
                          <thead class="table-light">
                            <tr>
                              <th width="5%">No</th>
                              <th width="45%">Kriteria Unjuk Kerja (KUK)</th>
                              <th width="10%" class="text-center">K</th>
                              <th width="10%" class="text-center">BK</th>
                              <th width="30%" class="text-center">Upload Bukti</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($elemen->kriteriaUnjukKerja as $kukIndex => $kuk)
                              @php 
                                $oldStatus = old("self_assessment.{$unit->id}.{$elemen->id}.{$kuk->id}.status"); 
                              @endphp
                              <tr>
                                <td class="text-center">{{ $kuk->no_urut }}</td>
                                <td>{{ $kuk->deskripsi }}</td>
                                <td class="text-center">
                                  <input type="radio"
                                         class="form-check-input"
                                         name="self_assessment[{{ $unit->id }}][{{ $elemen->id }}][{{ $kuk->id }}][status]"
                                         value="K"
                                         {{ $oldStatus === 'K' ? 'checked' : '' }}>
                                </td>
                                <td class="text-center">
                                  <input type="radio"
                                         class="form-check-input"
                                         name="self_assessment[{{ $unit->id }}][{{ $elemen->id }}][{{ $kuk->id }}][status]"
                                         value="BK"
                                         {{ $oldStatus === 'BK' ? 'checked' : '' }}>
                                </td>
                                <td>
                                  <input type="file"
                                         class="form-control form-control-sm"
                                         name="bukti_kompetensi[{{ $kuk->id }}]"
                                         accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                  <small class="text-muted">Max 2MB</small>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      @else
                        <div class="alert alert-warning">
                          <i class="bi bi-exclamation-triangle"></i> 
                          Tidak ada Kriteria Unjuk Kerja untuk elemen ini.
                        </div>
                      @endif
                    </div>
                  @endforeach
                @else
                  <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i> 
                    Tidak ada Elemen Kompetensi untuk unit ini.
                  </div>
                @endif

                <hr class="my-4">
              </div>
            @endforeach
          @else
            <div class="alert alert-warning">
              <i class="bi bi-exclamation-triangle"></i> 
              Tidak ada Unit Kompetensi untuk skema ini.
            </div>
          @endif
        </div>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <button type="button" class="btn btn-secondary btn-prev-tab">
          <i class="bi bi-arrow-left"></i> Sebelumnya
        </button>
        <button type="button" class="btn btn-primary btn-next-tab">
          Selanjutnya <i class="bi bi-arrow-right"></i>
        </button>
      </div>
    </div>

    {{-- TAB 6: REVIEW & SUBMIT --}}
    <div class="tab-content-item" id="tab-6">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">
            <i class="bi bi-check-circle"></i> Tab 6: Persyaratan Pendaftaran & Review
          </h5>
        </div>

        <div class="card-body">
          <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            Pastikan semua data yang Anda isi sudah benar sebelum mengirimkan pengajuan.
          </div>

          <div id="review-summary" class="mb-4">
            <h6 class="fw-bold">Ringkasan Pengajuan:</h6>
            <ul>
              <li><strong>Skema:</strong> {{ $program->nama }}</li>
              <li><strong>Kode Skema:</strong> {{ $program->kode_skema }}</li>
              <li><strong>Jumlah Unit:</strong> {{ $program->jumlah_unit }}</li>
            </ul>
          </div>

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

          <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="agree" name="agree" required {{ old('agree') ? 'checked' : '' }}>
            <label class="form-check-label" for="agree">
              Saya menyatakan bahwa seluruh data yang saya isi adalah benar dan saya menyetujui syarat & ketentuan yang berlaku.
            </label>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-between mt-4">
        <button type="button" class="btn btn-secondary btn-prev-tab">
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

{{-- MODAL TANDA TANGAN --}}
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
<script src="{{ asset('js/pengajuan-6tab.js') }}"></script>

</body>
</html>
