<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengajuan Skema - {{ $program->nama }}</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/pengajuan.css') }}">
</head>
<body>
    <div class="container py-5">
        <!-- Header -->
        <div class="text-center mb-5">
            <h2 class="fw-bold">Pengajuan Skema Sertifikasi</h2>
            <p class="text-muted">{{ $program->nama }}</p>
        </div>

        <!-- Progress Steps -->
        <div class="wizard-progress mb-5">
            <div class="step active" data-step="1">
                <div class="step-number">1</div>
                <div class="step-label">Data Pribadi</div>
            </div>
            <div class="step" data-step="2">
                <div class="step-number">2</div>
                <div class="step-label">Bukti & Dokumen</div>
            </div>
            <div class="step" data-step="3">
                <div class="step-number">3</div>
                <div class="step-label">Self Assessment</div>
            </div>
            <div class="step" data-step="4">
                <div class="step-number">4</div>
                <div class="step-label">Review & Submit</div>
            </div>
        </div>

        <!-- Form -->
        <form id="pengajuanForm" method="POST" action="{{ route('pengajuan.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="program_pelatihan_id" value="{{ $program->id }}">

            <!-- Step 1: Data Pribadi (APL-01) -->
            <div class="wizard-step active" id="step-1">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-person-fill"></i> APL-01: Data Pribadi</h5>
                    </div>
                    <div class="card-body">
                        <!-- Data Pribadi -->
                        <h6 class="fw-bold mb-3">A. Data Pribadi</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_lengkap" required value="{{ old('nama_lengkap', auth()->user()->nama) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NIK <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nik" maxlength="16" required value="{{ old('nik') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="tempat_lahir" required value="{{ old('tempat_lahir') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal_lahir" required value="{{ old('tanggal_lahir') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select" name="jenis_kelamin" required>
                                    <option value="">Pilih</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kebangsaan</label>
                                <input type="text" class="form-control" name="kebangsaan" value="{{ old('kebangsaan', 'Indonesia') }}">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Alamat Rumah <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="alamat_rumah" rows="2" required>{{ old('alamat_rumah') }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Kode Pos</label>
                                <input type="text" class="form-control" name="kode_pos" maxlength="10" value="{{ old('kode_pos') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Telepon Rumah</label>
                                <input type="text" class="form-control" name="telepon_rumah" value="{{ old('telepon_rumah') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">No. HP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="telepon_kantor" required value="{{ old('telepon_kantor', auth()->user()->no_hp) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" required value="{{ old('email', auth()->user()->email) }}">
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Pendidikan & Pekerjaan -->
                        <h6 class="fw-bold mb-3">B. Pendidikan & Pekerjaan</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Kualifikasi Pendidikan</label>
                                <select class="form-select" name="kualifikasi_pendidikan">
                                    <option value="">Pilih</option>
                                    <option value="SD" {{ old('kualifikasi_pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                                    <option value="SMP" {{ old('kualifikasi_pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="SMA/SMK" {{ old('kualifikasi_pendidikan') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                                    <option value="D1" {{ old('kualifikasi_pendidikan') == 'D1' ? 'selected' : '' }}>D1</option>
                                    <option value="D2" {{ old('kualifikasi_pendidikan') == 'D2' ? 'selected' : '' }}>D2</option>
                                    <option value="D3" {{ old('kualifikasi_pendidikan') == 'D3' ? 'selected' : '' }}>D3</option>
                                    <option value="S1" {{ old('kualifikasi_pendidikan') == 'S1' ? 'selected' : '' }}>S1</option>
                                    <option value="S2" {{ old('kualifikasi_pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ old('kualifikasi_pendidikan') == 'S3' ? 'selected' : '' }}>S3</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Institusi</label>
                                <input type="text" class="form-control" name="nama_institusi" value="{{ old('nama_institusi') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jabatan</label>
                                <input type="text" class="form-control" name="jabatan" value="{{ old('jabatan') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telepon Kantor</label>
                                <input type="text" class="form-control" name="telepon_kantor_pekerjaan" value="{{ old('telepon_kantor_pekerjaan') }}">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Alamat Kantor</label>
                                <textarea class="form-control" name="alamat_kantor" rows="2">{{ old('alamat_kantor') }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Fax</label>
                                <input type="text" class="form-control" name="fax" value="{{ old('fax') }}">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Email Kantor</label>
                                <input type="email" class="form-control" name="email_kantor" value="{{ old('email_kantor') }}">
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Sertifikat -->
                        <h6 class="fw-bold mb-3">C. Sertifikat yang Pernah Dimiliki (Jika Ada)</h6>
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
                    <a href="{{ route('Skema.show', $program->slug) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="button" class="btn btn-primary btn-next">
                        Selanjutnya <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- Step 2: Bukti & Upload -->
            <div class="wizard-step" id="step-2">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-file-earmark-text"></i> APL-01: Bukti & Dokumen</h5>
                    </div>
                    <div class="card-body">
                        <!-- Tujuan Asesmen -->
                        <h6 class="fw-bold mb-3">A. Tujuan Asesmen</h6>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tujuan_asesmen[]" value="PKT" id="tujuan_pkt">
                                <label class="form-check-label" for="tujuan_pkt">
                                    Peserta Kursus/Pelatihan (PKT)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tujuan_asesmen[]" value="RPL" id="tujuan_rpl">
                                <label class="form-check-label" for="tujuan_rpl">
                                    Rekognisi Pembelajaran Lampau (RPL)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tujuan_asesmen[]" value="RCC" id="tujuan_rcc">
                                <label class="form-check-label" for="tujuan_rcc">
                                    Recognition of Current Competency (RCC)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tujuan_asesmen[]" value="Lainnya" id="tujuan_lainnya">
                                <label class="form-check-label" for="tujuan_lainnya">
                                    Lainnya
                                </label>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Bukti Kelengkapan -->
                        <h6 class="fw-bold mb-3">B. Bukti Kelengkapan Persyaratan Dasar</h6>
                        <div class="mb-3">
                            <label class="form-label">Pilih bukti yang akan diserahkan:</label>
                            <textarea class="form-control" name="bukti_penyertaan_dasar" rows="3" placeholder="Contoh: Fotokopi KTP, Pas Foto, dll">{{ old('bukti_penyertaan_dasar') }}</textarea>
                        </div>

                        <h6 class="fw-bold mb-3">C. Bukti Administrasif</h6>
                        <div class="mb-3">
                            <label class="form-label">Dokumen administrasi pendukung:</label>
                            <textarea class="form-control" name="bukti_administrasif" rows="3" placeholder="Contoh: Ijazah, Transkrip Nilai, Sertifikat, dll">{{ old('bukti_administrasif') }}</textarea>
                        </div>

                        <hr class="my-4">

                        <!-- Upload Dokumen -->
                        <h6 class="fw-bold mb-3">D. Upload Dokumen Pendukung</h6>
                        <div class="mb-3">
                            <p class="text-muted small">Upload dokumen pendukung seperti KTP, Ijazah, Sertifikat, Portfolio, CV, dll. Format: PDF, JPG, PNG, DOC, DOCX. Maksimal 2MB per file.</p>
                            <div id="dokumen-container">
                                <div class="dokumen-item mb-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="form-select" name="jenis_dokumen[]">
                                                <option value="ktp">KTP</option>
                                                <option value="ijazah">Ijazah</option>
                                                <option value="sertifikat">Sertifikat</option>
                                                <option value="cv">CV</option>
                                                <option value="portfolio">Portfolio</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="file" class="form-control" name="dokumen[]" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="btn-add-dokumen">
                                <i class="bi bi-plus-circle"></i> Tambah Dokumen
                            </button>
                        </div>

                        <!-- Catatan -->
                        <div class="mb-3">
                            <label class="form-label">Catatan Tambahan (Opsional)</label>
                            <textarea class="form-control" name="catatan" rows="3" placeholder="Tuliskan catatan atau informasi tambahan jika ada">{{ old('catatan') }}</textarea>
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

            <!-- Step 3: Self Assessment (APL-02) -->
            <div class="wizard-step" id="step-3">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-clipboard-check"></i> APL-02: Asesmen Mandiri</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Lakukan penilaian mandiri terhadap kompetensi yang Anda miliki pada setiap unit kompetensi berikut:</p>
                        <p class="small"><strong>K</strong> = Kompeten | <strong>BK</strong> = Belum Kompeten</p>

                        @foreach($program->units as $index => $unit)
                        <div class="unit-assessment mb-4">
                            <h6 class="fw-bold">{{ $index + 1 }}. {{ $unit->judul_unit }}</h6>
                            <p class="small text-muted">Kode Unit: {{ $unit->kode_unit }}</p>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="60%">Elemen Kompetensi</th>
                                            <th width="15%" class="text-center">K</th>
                                            <th width="15%" class="text-center">BK</th>
                                            <th width="10%">Bukti</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for($i = 1; $i <= 3; $i++)
                                        <tr>
                                            <td>Elemen {{ $i }} - {{ $unit->judul_unit }}</td>
                                            <td class="text-center">
                                                <input type="radio" class="form-check-input" name="self_assessment[{{ $unit->id }}][{{ $i }}][status]" value="K">
                                            </td>
                                            <td class="text-center">
                                                <input type="radio" class="form-check-input" name="self_assessment[{{ $unit->id }}][{{ $i }}][status]" value="BK">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" name="self_assessment[{{ $unit->id }}][{{ $i }}][bukti]" placeholder="No. Bukti">
                                            </td>
                                        </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endforeach
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

            <!-- Step 4: Review & Submit -->
            <div class="wizard-step" id="step-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-check-circle"></i> Review & Submit</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Pastikan semua data yang Anda isi sudah benar sebelum mengirimkan pengajuan.
                        </div>

                        <div id="review-summary">
                            <!-- Summary will be generated by JavaScript -->
                        </div>

                        <hr class="my-4">

                        <!-- Tanda Tangan Digital -->
                        <h6 class="fw-bold mb-3">Tanda Tangan Digital</h6>
                        <input type="hidden" name="ttd_digital" id="ttd_digital">
                        <div class="mb-3">
                            <button class="btn btn-outline-primary btn-sm" id="open-signature-modal" type="button">
                                <i class="bi bi-pen"></i> Buat Tanda Tangan
                            </button>
                            <small class="text-muted ms-2">Anda dapat menggambar langsung atau mengunggah gambar tanda tangan.</small>
                        </div>
                        <div id="signature-preview" style="display:none;">
                            <p class="mb-1 small">Preview tanda tangan:</p>
                            <div class="border rounded p-2 bg-white" style="max-width: 300px;">
                                <img id="signature-preview-img" class="img-fluid" alt="Preview TTD">
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Persetujuan -->
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="setuju" name="setuju" required>
                            <label class="form-check-label" for="setuju">
                                Saya menyatakan bahwa seluruh data yang saya isi adalah benar dan saya menyetujui syarat & ketentuan yang berlaku.
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-secondary btn-prev">
                        <i class="bi bi-arrow-left"></i> Sebelumnya
                    </button>
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="bi bi-send"></i> Kirim Pengajuan
                    </button>
                </div>
            </div>
        </form>

        <!-- Auto-save indicator -->
        <div class="auto-save-indicator" id="auto-save-indicator">
            <i class="bi bi-cloud-check"></i> Draft tersimpan otomatis
        </div>
    </div>

    <!-- Modal TTD (reuse from daftar.blade.php) -->
    <div class="signature-modal-backdrop" id="signature-modal-backdrop">
        <div class="signature-modal">
            <div class="signature-modal-header">
                <span>Tanda Tangan Digital</span>
                <button type="button" class="close-signature-modal" aria-label="Close">&times;</button>
            </div>

            <div class="signature-modal-body">
                <p class="mb-2" style="font-size:13px;">
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

    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/pengajuan-wizard.js') }}"></script>
</body>
</html>
