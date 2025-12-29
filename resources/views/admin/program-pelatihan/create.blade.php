@extends('layouts.admin')

@section('title', 'Tambah Program Pelatihan')
@section('page_title', 'Tambah Program Pelatihan')

@section('content')
<div class="admin-table">
    <h5 class="mb-3">Tambah Program Pelatihan</h5>

    <form action="{{ route('admin.program-pelatihan.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.program-pelatihan._form', ['program' => null])
    </form>
</div>
@push('scripts')
<script>
    // ========== UNIT KOMPETENSI ==========
    const unitWrapper = document.getElementById('unit-wrapper');
    const addUnitBtn   = document.getElementById('add-unit');

    if (addUnitBtn) {
        addUnitBtn.addEventListener('click', function () {
            let unitCount = unitWrapper.querySelectorAll('.unit-card').length;
            let unitIndex = unitCount;

            let unitCard = `
                <div class="unit-card card mb-3">
                    <div class="card-header bg-light">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <strong>Unit ${unitCount + 1}</strong>
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
                                        <input type="text" name="elemen_nama[${unitIndex}][]" 
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
                </div>`;
            unitWrapper.insertAdjacentHTML('beforeend', unitCard);
            updateUnitNumbers();
        });
    }

    // Hapus baris unit
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-unit')) {
            const card = e.target.closest('.unit-card');
            if (card && unitWrapper.querySelectorAll('.unit-card').length > 1) {
                card.remove();
                updateUnitNumbers();
            } else {
                alert('Minimal harus ada 1 unit kompetensi');
            }
        }
    });

    // Update unit numbers and elemen name attributes
    function updateUnitNumbers() {
        const unitCards = unitWrapper.querySelectorAll('.unit-card');
        unitCards.forEach((card, unitIndex) => {
            // Update unit label
            const unitLabel = card.querySelector('.card-header strong');
            if (unitLabel) {
                unitLabel.textContent = `Unit ${unitIndex + 1}`;
            }

            // Update elemen name attributes
            const elemenInputs = card.querySelectorAll('.elemen-wrapper input[type="text"]');
            elemenInputs.forEach(input => {
                const currentName = input.getAttribute('name');
                const newName = currentName.replace(/elemen_nama\[\d+\]/, `elemen_nama[${unitIndex}]`);
                input.setAttribute('name', newName);
            });

            // Update elemen row numbers
            updateElemenNumbers(card);
        });
    }

    // ========== ELEMEN KOMPETENSI ==========
    // Add elemen to a unit
    document.addEventListener('click', function (e) {
        if (e.target.closest('.add-elemen')) {
            const button = e.target.closest('.add-elemen');
            const card = button.closest('.unit-card');
            const tbody = card.querySelector('.elemen-wrapper');
            const unitCards = Array.from(unitWrapper.querySelectorAll('.unit-card'));
            const unitIndex = unitCards.indexOf(card);
            const elemenCount = tbody.querySelectorAll('tr').length;

            const row = `
                <tr>
                    <td class="text-center">${elemenCount + 1}</td>
                    <td>
                        <input type="text" name="elemen_nama[${unitIndex}][]" 
                               class="form-control form-control-sm"
                               placeholder="Nama Elemen Kompetensi" required>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm remove-elemen">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>`;
            tbody.insertAdjacentHTML('beforeend', row);
        }
    });

    // Remove elemen from a unit
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-elemen')) {
            const button = e.target.closest('.remove-elemen');
            const row = button.closest('tr');
            const tbody = row.closest('.elemen-wrapper');
            
            if (tbody.querySelectorAll('tr').length > 1) {
                row.remove();
                updateElemenNumbers(row.closest('.unit-card'));
            } else {
                alert('Minimal harus ada 1 elemen kompetensi per unit');
            }
        }
    });

    // Update elemen row numbers
    function updateElemenNumbers(card) {
        const rows = card.querySelectorAll('.elemen-wrapper tr');
        rows.forEach((row, index) => {
            const noCell = row.querySelector('td:first-child');
            if (noCell) {
                noCell.textContent = index + 1;
            }
        });
    }


    // ========== PROFESI TERKAIT ==========
    const profesiWrapper = document.getElementById('profesi-wrapper');
    const addProfesiBtn  = document.getElementById('add-profesi');

    if (addProfesiBtn) {
        addProfesiBtn.addEventListener('click', function () {
            let rowCount = profesiWrapper.rows.length + 1;

            let row = `
                <tr>
                    <td class="text-center">${rowCount}</td>
                    <td>
                        <input type="text" name="profesi_nama[]" class="form-control" required>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm remove-profesi">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>`;
            profesiWrapper.insertAdjacentHTML('beforeend', row);
        });
    }

    // Hapus baris profesi
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-profesi')) {
            e.target.closest('tr').remove();
        }
    });
</script>
@endpush
@endsection
