@csrf

<link rel="stylesheet" href="{{ asset('vendor/quill/quill.snow.css') }}">

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Kode Skema *</label>
        <input type="text" name="kode_skema" class="form-control @error('kode_skema') is-invalid @enderror"
               value="{{ old('kode_skema', $program->kode_skema ?? '') }}" required>
        @error('kode_skema')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Nama Program *</label>
        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
               value="{{ old('nama', $program->nama ?? '') }}" required>
        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Kategori *</label>
        <input type="text" name="kategori" class="form-control @error('kategori') is-invalid @enderror"
               value="{{ old('kategori', $program->kategori ?? '') }}" placeholder="contoh: Pemasaran, Perkantoran" required>
        @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Rujukan SKKNI</label>
        <input type="text" name="rujukan_skkni"
               class="form-control @error('rujukan_skkni') is-invalid @enderror"
               value="{{ old('rujukan_skkni', $program->rujukan_skkni ?? '') }}"
               placeholder="contoh: Kepmenaker No. xxx Tahun xxxx">
        @error('rujukan_skkni')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label">Jumlah Unit *</label>
        <input type="number" name="jumlah_unit"
               class="form-control @error('jumlah_unit') is-invalid @enderror"
               value="{{ old('jumlah_unit', $program->jumlah_unit ?? 0) }}" min="0" required>
        @error('jumlah_unit')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Estimasi Biaya</label>
        <input type="number" name="estimasi_biaya"
               class="form-control @error('estimasi_biaya') is-invalid @enderror"
               value="{{ old('estimasi_biaya', $program->estimasi_biaya ?? '') }}"
               placeholder="contoh: 1000000">
        @error('estimasi_biaya')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-5 mb-3">
        <label class="form-label">Satuan Biaya</label>
        <input type="text" name="biaya"
               class="form-control @error('biaya') is-invalid @enderror"
               value="{{ old('biaya', $program->biaya ?? 'IDR') }}">
        @error('biaya')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 mb-3">
        <label class="form-label">Deskripsi Singkat</label>
        <input type="text" name="deskripsi_singkat"
               class="form-control @error('deskripsi_singkat') is-invalid @enderror"
               value="{{ old('deskripsi_singkat', $program->deskripsi_singkat ?? '') }}">
        @error('deskripsi_singkat')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

  {{-- RINGKASAN SKEMA --}}
<div class="col-12 mb-3">
    <label class="form-label">Ringkasan Skema</label>

    {{-- TEXTAREA SEBENARNYA (DISEMBUNYIKAN) --}}
    <textarea
        name="ringkasan"
        id="ringkasan-textarea"
        class="d-none"
    >{{ old('ringkasan', $program->ringkasan ?? '') }}</textarea>

    {{-- EDITOR QUILL --}}
    <div id="editor-ringkasan" style="height: 200px;"></div>

    @error('ringkasan')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

{{-- PERSYARATAN PESERTA --}}
<div class="col-12 mb-3">
    <label class="form-label">Persyaratan Peserta</label>

    {{-- TEXTAREA SEBENARNYA (DISEMBUNYIKAN) --}}
    <textarea
        name="persyaratan_peserta"
        id="persyaratan-textarea"
        class="d-none"
    >{{ old('persyaratan_peserta', $program->persyaratan_peserta ?? '') }}</textarea>

    {{-- EDITOR QUILL --}}
    <div id="editor-persyaratan" style="height: 200px;"></div>

    @error('persyaratan_peserta')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>


{{-- METODE ASESMEN --}}
<div class="col-12 mb-3">
    <label class="form-label">Metode Assemen</label>

    {{-- TEXTAREA SEBENARNYA (DISEMBUNYIKAN) --}}
    <textarea
        name="metode_asesmen"
        id="metode-textarea"
        class="d-none"
    >{{ old('metode_asesmen', $program->metode_asesmen ?? '') }}</textarea>

    {{-- EDITOR QUILL --}}
    <div id="editor-metode" style="height: 200px;"></div>

    @error('metode_asesmen')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>



    <div class="col-md-6 mb-3">
        <label class="form-label">Gambar Poster Skema</label>
        @if(!empty($program->gambar))
            <div class="mb-2">
                <img src="{{ asset('storage/'.$program->gambar) }}" alt="Gambar" style="max-height: 120px;">
            </div>
        @endif
        <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror">
        <small class="text-muted">Format: JPG/PNG, maks 2MB</small>
        @error('gambar')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">File Panduan Skema (PDF/DOC)</label>
        @if(!empty($program->file_panduan))
            <div class="mb-2">
                <a href="{{ asset('storage/'.$program->file_panduan) }}" target="_blank">
                    Lihat file panduan saat ini
                </a>
            </div>
        @endif
        <input type="file" name="file_panduan"
               class="form-control @error('file_panduan') is-invalid @enderror">
        @error('file_panduan')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12 mb-3 form-check">
        <input type="checkbox" name="is_published" id="is_published"
               class="form-check-input"
               {{ old('is_published', $program->is_published ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_published">Publish program ini</label>
    </div>
    <hr>
<h6 class="mt-4 mb-2 fw-bold">Unit Kompetensi</h6>

<div id="unit-wrapper">
    @if(isset($program) && $program && $program->units->count())
        @foreach($program->units as $unitIndex => $unit)
            <div class="unit-card card mb-3">
                <div class="card-header bg-light">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <strong>Unit {{ $unitIndex + 1 }}</strong>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="unit_kode[]" class="form-control form-control-sm"
                                   value="{{ $unit->kode_unit }}" placeholder="Kode Unit" required>
                        </div>
                        <div class="col">
                            <input type="text" name="unit_judul[]" class="form-control form-control-sm"
                                   value="{{ $unit->judul_unit }}" placeholder="Judul Unit" required>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger btn-sm remove-unit">
                                <i class="bi bi-trash"></i> Hapus Unit
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-2">Elemen Kompetensi</h6>
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Nama Elemen Kompetensi</th>
                                <th width="80">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="elemen-wrapper">
                            @if($unit->elemenKompetensis && $unit->elemenKompetensis->count())
                                @foreach($unit->elemenKompetensis as $elemenIndex => $elemen)
                                    <tr>
                                        <td class="text-center">{{ $elemenIndex + 1 }}</td>
                                        <td>
                                            <input type="text" name="elemen_nama[{{ $unitIndex }}][]" 
                                                   class="form-control form-control-sm"
                                                   value="{{ $elemen->nama_elemen }}" 
                                                   placeholder="Nama Elemen Kompetensi" required>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm remove-elemen">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>
                                        <input type="text" name="elemen_nama[{{ $unitIndex }}][]" 
                                               class="form-control form-control-sm"
                                               placeholder="Nama Elemen Kompetensi" required>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm remove-elemen">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-outline-secondary btn-sm add-elemen">
                        <i class="bi bi-plus-circle"></i> Tambah Elemen
                    </button>
                </div>
            </div>
        @endforeach
    @else
        <div class="unit-card card mb-3">
            <div class="card-header bg-light">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <strong>Unit 1</strong>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="unit_kode[]" class="form-control form-control-sm"
                               placeholder="Kode Unit" required>
                    </div>
                    <div class="col">
                        <input type="text" name="unit_judul[]" class="form-control form-control-sm"
                               placeholder="Judul Unit" required>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-danger btn-sm remove-unit">
                            <i class="bi bi-trash"></i> Hapus Unit
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h6 class="mb-2">Elemen Kompetensi</h6>
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Elemen Kompetensi</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="elemen-wrapper">
                        <tr>
                            <td class="text-center">1</td>
                            <td>
                                <input type="text" name="elemen_nama[0][]" 
                                       class="form-control form-control-sm"
                                       placeholder="Nama Elemen Kompetensi" required>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm remove-elemen">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-outline-secondary btn-sm add-elemen">
                    <i class="bi bi-plus-circle"></i> Tambah Elemen
                </button>
            </div>
        </div>
    @endif
</div>

<button type="button" class="btn btn-outline-primary btn-sm" id="add-unit">
    <i class="bi bi-plus-circle"></i> Tambah Unit
</button>

{{-- =====================================
     PROFESI TERKAIT + ICON
====================================== --}}
<hr>
<h6 class="mt-4 mb-2 fw-bold">Profesi Terkait</h6>
<p class="text-muted mb-2" style="font-size: 13px;">
    Cantumkan jabatan/posisi kerja yang relevan + icon (Bootstrap Icons).
</p>

<table class="table table-bordered align-middle">
    <thead>
    <tr>
        <th width="50">No</th>
        <th width="200">Icon (Bootstrap)</th>
        <th>Nama Profesi</th>
        <th width="80">Aksi</th>
    </tr>
    </thead>

    <tbody id="profesi-wrapper">
    @php
        $profesis = (isset($program) && $program)
            ? $program->profesiTerkait
            : collect();
    @endphp

    @if($profesis->count())
        @foreach($profesis as $i => $profesi)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>

                <td>
                    <div class="d-flex gap-2 align-items-center">
                        <input type="text"
                               name="profesi_icon[]"
                               class="form-control form-control-sm profesi-icon-input"
                               value="{{ $profesi->icon }}"
                               placeholder="Contoh: bi-graph-up">
                        <i class="bi {{ $profesi->icon }} fs-5 preview-icon"></i>
                    </div>
                </td>

                <td>
                    <input type="text"
                           name="profesi_nama[]"
                           class="form-control"
                           value="{{ $profesi->nama }}"
                           placeholder="Contoh: Staff Administrasi"
                           required>
                </td>

                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-profesi">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    @else
        {{-- Row default jika belum ada data --}}
        <tr>
            <td class="text-center">1</td>

            <td>
                <div class="d-flex gap-2 align-items-center">
                    <input type="text"
                           name="profesi_icon[]"
                           class="form-control form-control-sm profesi-icon-input"
                           placeholder="Contoh: bi-briefcase">
                    <i class="bi bi-briefcase fs-5 preview-icon"></i>
                </div>
            </td>

            <td>
                <input type="text"
                       name="profesi_nama[]"
                       class="form-control"
                       placeholder="Contoh: Staff Administrasi">
            </td>

            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm remove-profesi">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
    @endif
    </tbody>
</table>

<button type="button" class="btn btn-outline-primary btn-sm" id="add-profesi">
    <i class="bi bi-plus-circle"></i> Tambah Profesi
</button>



</div>

<div class="mt-3">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i> Simpan
    </button>
    <a href="{{ route('admin.program-pelatihan.index') }}" class="btn btn-secondary">
        Batal
    </a>
</div>


<script src="{{ asset('vendor/quill/quill.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Textarea asli (yang akan dikirim ke backend)
    const ringkasanTextarea   = document.getElementById('ringkasan-textarea');
    const persyaratanTextarea = document.getElementById('persyaratan-textarea');
    const metodeTextarea      = document.getElementById('metode-textarea');

    // Quill untuk Ringkasan
    const quillRingkasan = new Quill('#editor-ringkasan', {
        theme: 'snow',
        placeholder: 'Tulis ringkasan skema di sini...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link'],
                ['clean']
            ]
        }
    });

    // Isi awal editor dari textarea
    quillRingkasan.root.innerHTML = ringkasanTextarea.value || '';

    // Quill untuk Persyaratan
    const quillPersyaratan = new Quill('#editor-persyaratan', {
        theme: 'snow',
        placeholder: 'Tulis persyaratan di sini...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link'],
                ['clean']
            ]
        }
    });

    quillPersyaratan.root.innerHTML = persyaratanTextarea.value || '';

    const quillMetode = new Quill('#editor-metode', {
        theme: 'snow',
        placeholder: 'Tulis metode di sini...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link'],
                ['clean']
            ]
        }
    });

    quillMetode.root.innerHTML = metodeTextarea.value || '';

    // Saat FORM DISUBMIT → salin HTML dari Quill ke textarea
    const form = ringkasanTextarea.closest('form');  // ambil form terdekat
    form.addEventListener('submit', function () {
        ringkasanTextarea.value   = quillRingkasan.root.innerHTML;
        persyaratanTextarea.value = quillPersyaratan.root.innerHTML;
        metodeTextarea.value      = quillMetode.root.innerHTML;
    });
});
</script>





<script>
document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('#editor')) {
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    }
});
</script>

<!-- Profesi -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const wrapper = document.getElementById('profesi-wrapper');
    const addBtn  = document.getElementById('add-profesi');

    // Tambah baris baru
    addBtn.addEventListener('click', function () {
        // Hitung jumlah <tr> yang ada sekarang
        const index = wrapper.querySelectorAll('tr').length + 1;

        const row = `
            <tr>
                <td class="text-center">${index}</td>

                <td>
                    <div class="d-flex gap-2 align-items-center">
                        <input type="text"
                               name="profesi_icon[]"
                               class="form-control form-control-sm profesi-icon-input"
                               placeholder="Contoh: bi-instagram">
                        <i class="bi bi-question-circle fs-5 preview-icon"></i>
                    </div>
                </td>

                <td>
                    <input type="text"
                           name="profesi_nama[]"
                           class="form-control"
                           placeholder="Contoh: Social Media Specialist">
                </td>

                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm remove-profesi">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;

        wrapper.insertAdjacentHTML('beforeend', row);
    });

    // Hapus baris ketika klik ikon trash
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-profesi')) {
            e.preventDefault();
            const row = e.target.closest('tr');
            if (row) row.remove();

            // Setelah hapus, update ulang nomor (kolom No)
            wrapper.querySelectorAll('tr').forEach((tr, idx) => {
                const noCell = tr.querySelector('td:first-child');
                if (noCell) noCell.textContent = idx + 1;
            });
        }
    });

    // Preview icon live
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('profesi-icon-input')) {
            const iconClass = e.target.value.trim();
            const preview   = e.target.closest('td').querySelector('.preview-icon');

            preview.className = 'bi fs-5 preview-icon'; // reset
            if (iconClass) {
                preview.classList.add(iconClass);
            }
        }
    });
});
</script>

