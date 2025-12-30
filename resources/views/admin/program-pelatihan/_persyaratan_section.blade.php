{{-- resources/views/admin/program-pelatihan/_persyaratan_section.blade.php --}}

{{-- Section for managing Persyaratan Dasar --}}
<div class="card mb-4">
    <div class="card-header bg-info text-white">
        <h6 class="mb-0">
            <i class="bi bi-file-earmark-check"></i> Persyaratan Dasar
        </h6>
    </div>
    <div class="card-body">
        <p class="text-muted small">Dokumen persyaratan dasar yang harus dipenuhi peserta (akan tampil di Tab 2)</p>
        
        <div id="persyaratan-dasar-wrapper">
            @if(isset($program) && $program->persyaratanDasar && $program->persyaratanDasar->count() > 0)
                @foreach($program->persyaratanDasar as $index => $item)
                    <div class="persyaratan-item border rounded p-3 mb-2">
                        <input type="hidden" name="persyaratan_dasar_id[]" value="{{ $item->id }}">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-1">
                                <input type="number" name="persyaratan_dasar_urutan[]" class="form-control form-control-sm" 
                                       value="{{ $item->urutan }}" placeholder="No" min="1">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="persyaratan_dasar_nama[]" class="form-control form-control-sm" 
                                       value="{{ $item->nama_dokumen }}" placeholder="Nama dokumen (mis: Copy ijazah D3)" required>
                            </div>
                            <div class="col-md-2">
                                <select name="persyaratan_dasar_tipe[]" class="form-select form-select-sm">
                                    <option value="file_upload" {{ $item->tipe_dokumen === 'file_upload' ? 'selected' : '' }}>File Upload</option>
                                    <option value="text" {{ $item->tipe_dokumen === 'text' ? 'selected' : '' }}>Text</option>
                                    <option value="checkbox" {{ $item->tipe_dokumen === 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" name="persyaratan_dasar_wajib[]" value="1" 
                                           class="form-check-input" {{ $item->is_wajib ? 'checked' : '' }}>
                                    <label class="form-check-label">Wajib</label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm remove-persyaratan-dasar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        
        <button type="button" class="btn btn-sm btn-outline-primary" id="add-persyaratan-dasar">
            <i class="bi bi-plus-circle"></i> Tambah Persyaratan Dasar
        </button>
    </div>
</div>

{{-- Section for managing Bukti Administratif --}}
<div class="card mb-4">
    <div class="card-header bg-warning text-dark">
        <h6 class="mb-0">
            <i class="bi bi-file-earmark-person"></i> Bukti Administratif
        </h6>
    </div>
    <div class="card-body">
        <p class="text-muted small">Dokumen administratif yang harus dilampirkan (akan tampil di Tab 3)</p>
        
        <div id="bukti-administratif-wrapper">
            @if(isset($program) && $program->buktiAdministratif && $program->buktiAdministratif->count() > 0)
                @foreach($program->buktiAdministratif as $index => $item)
                    <div class="bukti-administratif-item border rounded p-3 mb-2">
                        <input type="hidden" name="bukti_administratif_id[]" value="{{ $item->id }}">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-1">
                                <input type="number" name="bukti_administratif_urutan[]" class="form-control form-control-sm" 
                                       value="{{ $item->urutan }}" placeholder="No" min="1">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="bukti_administratif_nama[]" class="form-control form-control-sm" 
                                       value="{{ $item->nama_dokumen }}" placeholder="Nama dokumen (mis: Copy KTP)" required>
                            </div>
                            <div class="col-md-2">
                                <select name="bukti_administratif_tipe[]" class="form-select form-select-sm">
                                    <option value="file_upload" {{ $item->tipe_dokumen === 'file_upload' ? 'selected' : '' }}>File Upload</option>
                                    <option value="text" {{ $item->tipe_dokumen === 'text' ? 'selected' : '' }}>Text</option>
                                    <option value="checkbox" {{ $item->tipe_dokumen === 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" name="bukti_administratif_wajib[]" value="1" 
                                           class="form-check-input" {{ $item->is_wajib ? 'checked' : '' }}>
                                    <label class="form-check-label">Wajib</label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm remove-bukti-administratif">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        
        <button type="button" class="btn btn-sm btn-outline-warning" id="add-bukti-administratif">
            <i class="bi bi-plus-circle"></i> Tambah Bukti Administratif
        </button>
    </div>
</div>

{{-- Section for managing Bukti Portofolio Template --}}
<div class="card mb-4">
    <div class="card-header bg-success text-white">
        <h6 class="mb-0">
            <i class="bi bi-folder"></i> Template Bukti Portofolio
        </h6>
    </div>
    <div class="card-body">
        <p class="text-muted small">Dokumen portofolio yang dapat dilampirkan (akan tampil di Tab 4)</p>
        
        <div id="bukti-portofolio-wrapper">
            @if(isset($program) && $program->buktiPortofolioTemplate && $program->buktiPortofolioTemplate->count() > 0)
                @foreach($program->buktiPortofolioTemplate as $index => $item)
                    <div class="bukti-portofolio-item border rounded p-3 mb-2">
                        <input type="hidden" name="bukti_portofolio_id[]" value="{{ $item->id }}">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-1">
                                <input type="number" name="bukti_portofolio_urutan[]" class="form-control form-control-sm" 
                                       value="{{ $item->urutan }}" placeholder="No" min="1">
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="bukti_portofolio_nama[]" class="form-control form-control-sm" 
                                       value="{{ $item->nama_dokumen }}" placeholder="Nama dokumen (mis: Surat Keterangan Kerja)" required>
                            </div>
                            <div class="col-md-2">
                                <div class="form-check">
                                    <input type="checkbox" name="bukti_portofolio_wajib[]" value="1" 
                                           class="form-check-input" {{ $item->is_wajib ? 'checked' : '' }}>
                                    <label class="form-check-label">Wajib</label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm remove-bukti-portofolio">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        
        <button type="button" class="btn btn-sm btn-outline-success" id="add-bukti-portofolio">
            <i class="bi bi-plus-circle"></i> Tambah Template Portofolio
        </button>
    </div>
</div>

{{-- JavaScript for dynamic adding/removing items --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Persyaratan Dasar
    document.getElementById('add-persyaratan-dasar')?.addEventListener('click', function() {
        const wrapper = document.getElementById('persyaratan-dasar-wrapper');
        const itemCount = wrapper.querySelectorAll('.persyaratan-item').length + 1;
        
        const html = `
            <div class="persyaratan-item border rounded p-3 mb-2">
                <input type="hidden" name="persyaratan_dasar_id[]" value="">
                <div class="row g-2 align-items-center">
                    <div class="col-md-1">
                        <input type="number" name="persyaratan_dasar_urutan[]" class="form-control form-control-sm" 
                               value="${itemCount}" placeholder="No" min="1">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="persyaratan_dasar_nama[]" class="form-control form-control-sm" 
                               placeholder="Nama dokumen (mis: Copy ijazah D3)" required>
                    </div>
                    <div class="col-md-2">
                        <select name="persyaratan_dasar_tipe[]" class="form-select form-select-sm">
                            <option value="file_upload">File Upload</option>
                            <option value="text">Text</option>
                            <option value="checkbox">Checkbox</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input type="checkbox" name="persyaratan_dasar_wajib[]" value="1" 
                                   class="form-check-input" checked>
                            <label class="form-check-label">Wajib</label>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm remove-persyaratan-dasar">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        wrapper.insertAdjacentHTML('beforeend', html);
    });

    // Bukti Administratif
    document.getElementById('add-bukti-administratif')?.addEventListener('click', function() {
        const wrapper = document.getElementById('bukti-administratif-wrapper');
        const itemCount = wrapper.querySelectorAll('.bukti-administratif-item').length + 1;
        
        const html = `
            <div class="bukti-administratif-item border rounded p-3 mb-2">
                <input type="hidden" name="bukti_administratif_id[]" value="">
                <div class="row g-2 align-items-center">
                    <div class="col-md-1">
                        <input type="number" name="bukti_administratif_urutan[]" class="form-control form-control-sm" 
                               value="${itemCount}" placeholder="No" min="1">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="bukti_administratif_nama[]" class="form-control form-control-sm" 
                               placeholder="Nama dokumen (mis: Copy KTP)" required>
                    </div>
                    <div class="col-md-2">
                        <select name="bukti_administratif_tipe[]" class="form-select form-select-sm">
                            <option value="file_upload">File Upload</option>
                            <option value="text">Text</option>
                            <option value="checkbox">Checkbox</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input type="checkbox" name="bukti_administratif_wajib[]" value="1" 
                                   class="form-check-input" checked>
                            <label class="form-check-label">Wajib</label>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm remove-bukti-administratif">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        wrapper.insertAdjacentHTML('beforeend', html);
    });

    // Bukti Portofolio
    document.getElementById('add-bukti-portofolio')?.addEventListener('click', function() {
        const wrapper = document.getElementById('bukti-portofolio-wrapper');
        const itemCount = wrapper.querySelectorAll('.bukti-portofolio-item').length + 1;
        
        const html = `
            <div class="bukti-portofolio-item border rounded p-3 mb-2">
                <input type="hidden" name="bukti_portofolio_id[]" value="">
                <div class="row g-2 align-items-center">
                    <div class="col-md-1">
                        <input type="number" name="bukti_portofolio_urutan[]" class="form-control form-control-sm" 
                               value="${itemCount}" placeholder="No" min="1">
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="bukti_portofolio_nama[]" class="form-control form-control-sm" 
                               placeholder="Nama dokumen (mis: Surat Keterangan Kerja)" required>
                    </div>
                    <div class="col-md-2">
                        <div class="form-check">
                            <input type="checkbox" name="bukti_portofolio_wajib[]" value="1" 
                                   class="form-check-input">
                            <label class="form-check-label">Wajib</label>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm remove-bukti-portofolio">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        wrapper.insertAdjacentHTML('beforeend', html);
    });

    // Remove buttons using event delegation
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-persyaratan-dasar')) {
            e.target.closest('.persyaratan-item').remove();
        }
        if (e.target.closest('.remove-bukti-administratif')) {
            e.target.closest('.bukti-administratif-item').remove();
        }
        if (e.target.closest('.remove-bukti-portofolio')) {
            e.target.closest('.bukti-portofolio-item').remove();
        }
    });
});
</script>
@endpush
