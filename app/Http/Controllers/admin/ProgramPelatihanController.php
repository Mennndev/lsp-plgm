<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramPelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\UnitKompetensi;
use App\Models\ProfesiTerkait;
use Mews\Purifier\Facades\Purifier;

class ProgramPelatihanController extends Controller
{
    public function index()
    {
        $programs = ProgramPelatihan::orderByDesc('created_at')->paginate(10);

        return view('admin.program-pelatihan.index', compact('programs'));
    }

    public function create()
    {
        // untuk form create
        return view('admin.program-pelatihan.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        // Sanitasi HTML dari Quill
    if (isset($data['ringkasan'])) {
        $data['ringkasan'] = Purifier::clean($data['ringkasan']);
    }

    if (isset($data['persyaratan_peserta'])) {
        $data['persyaratan_peserta'] = Purifier::clean($data['persyaratan_peserta']);
    }
        // slug otomatis dari nama
        $data['slug'] = Str::slug($data['nama']);
        $data['kategori_slug'] = Str::slug($data['kategori']);

        // handle upload gambar
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('program/gambar', 'public');
        }

        // handle upload file panduan
        if ($request->hasFile('file_panduan')) {
            $data['file_panduan'] = $request->file('file_panduan')->store('program/panduan', 'public');
        }

        // checkbox publish
        $data['is_published'] = $request->boolean('is_published', false);

        $program = ProgramPelatihan::create($data);

/* ====== SIMPAN UNIT KOMPETENSI ====== */
if ($request->unit_kode) {
    foreach ($request->unit_kode as $i => $kode) {
        if ($kode && $request->unit_judul[$i]) {
            $unit = UnitKompetensi::create([
                'program_pelatihan_id' => $program->id,
                'no_urut'    => $i + 1,
                'kode_unit'  => $kode,
                'judul_unit' => $request->unit_judul[$i],
            ]);

            // Simpan elemen kompetensi untuk unit ini
            if (isset($request->elemen_nama[$i]) && is_array($request->elemen_nama[$i])) {
                foreach ($request->elemen_nama[$i] as $elemenIndex => $namaElemen) {
                    if ($namaElemen) {
                        \App\Models\ElemenKompetensi::create([
                            'unit_kompetensi_id' => $unit->id,
                            'no_urut' => $elemenIndex + 1,
                            'nama_elemen' => $namaElemen,
                        ]);
                    }
                }
            }
        }
    }
}

/* ====== SIMPAN PROFESI TERKAIT ====== */
if ($request->profesi_nama) {
    foreach ($request->profesi_nama as $index => $nama) {
        if ($nama) {
            if (! $nama) {
                continue;
            }
            $icon = $request->profesi_icon[$index] ?? null;
            ProfesiTerkait::create([
                'program_pelatihan_id' => $program->id,
                'nama' => $nama,
                'icon' => $icon,
            ]);
        }
    }
}



        return redirect()
            ->route('admin.program-pelatihan.index')
            ->with('success', 'Program pelatihan berhasil ditambahkan.');
    }

    public function edit(ProgramPelatihan $program_pelatihan)
    {
        // parameter nama variabel mengikuti resource route (program_pelatihan)
        return view('admin.program-pelatihan.edit', [
            'program' => $program_pelatihan,
        ]);
    }

   public function update(Request $request, ProgramPelatihan $program_pelatihan)
{
    $data = $this->validateData($request, $program_pelatihan->id);

    $data['slug']          = Str::slug($data['nama']);
    $data['kategori_slug'] = Str::slug($data['kategori']);
    $data['is_published']  = $request->boolean('is_published', false);

    // ganti gambar jika upload baru
    if ($request->hasFile('gambar')) {
        if ($program_pelatihan->gambar && Storage::disk('public')->exists($program_pelatihan->gambar)) {
            Storage::disk('public')->delete($program_pelatihan->gambar);
        }
        $data['gambar'] = $request->file('gambar')->store('program/gambar', 'public');
    }

    // ganti file panduan jika upload baru
    if ($request->hasFile('file_panduan')) {
        if ($program_pelatihan->file_panduan && Storage::disk('public')->exists($program_pelatihan->file_panduan)) {
            Storage::disk('public')->delete($program_pelatihan->file_panduan);
        }
        $data['file_panduan'] = $request->file('file_panduan')->store('program/panduan', 'public');
    }

    // ⬇️ INI YANG PENTING: simpan perubahan ke tabel program_pelatihans
    $program_pelatihan->update($data);

    /* ====== UPDATE UNIT KOMPETENSI ====== */
    $program_pelatihan->units()->delete();

    if ($request->unit_kode) {
        foreach ($request->unit_kode as $i => $kode) {
            if ($kode && $request->unit_judul[$i]) {
                $unit = UnitKompetensi::create([
                    'program_pelatihan_id' => $program_pelatihan->id,
                    'no_urut'    => $i + 1,
                    'kode_unit'  => $kode,
                    'judul_unit' => $request->unit_judul[$i],
                ]);

                // Simpan elemen kompetensi untuk unit ini
                if (isset($request->elemen_nama[$i]) && is_array($request->elemen_nama[$i])) {
                    foreach ($request->elemen_nama[$i] as $elemenIndex => $namaElemen) {
                        if ($namaElemen) {
                            \App\Models\ElemenKompetensi::create([
                                'unit_kompetensi_id' => $unit->id,
                                'no_urut' => $elemenIndex + 1,
                                'nama_elemen' => $namaElemen,
                            ]);
                        }
                    }
                }
            }
        }
    }

    /* ====== UPDATE PROFESI TERKAIT ====== */
    $program_pelatihan->profesiTerkait()->delete();

    if ($request->profesi_nama) {
        foreach ($request->profesi_nama as $index => $nama) {
            if (! $nama) continue;

            $icon = $request->profesi_icon[$index] ?? null;
            ProfesiTerkait::create([
                'program_pelatihan_id' => $program_pelatihan->id,
                'nama' => $nama,
                'icon' => $icon,
            ]);
        }
    }

    return redirect()
        ->route('admin.program-pelatihan.index')
        ->with('success', 'Program pelatihan berhasil diperbarui.');
}


    public function destroy(ProgramPelatihan $program_pelatihan)
    {
        // hapus file jika ada
        if ($program_pelatihan->gambar && Storage::disk('public')->exists($program_pelatihan->gambar)) {
            Storage::disk('public')->delete($program_pelatihan->gambar);
        }

        if ($program_pelatihan->file_panduan && Storage::disk('public')->exists($program_pelatihan->file_panduan)) {
            Storage::disk('public')->delete($program_pelatihan->file_panduan);
        }

        $program_pelatihan->delete();

        return redirect()
            ->route('admin.program-pelatihan.index')
            ->with('success', 'Program pelatihan berhasil dihapus.');
    }

    /**
     * Validasi data create & update
     */
    protected function validateData(Request $request, $ignoreId = null): array
    {
        $uniqueKode = 'unique:program_pelatihans,kode_skema';
        if ($ignoreId) {
            $uniqueKode .= ',' . $ignoreId;
        }

        return $request->validate([
            'kode_skema'        => ['required', 'string', 'max:255', $uniqueKode],
            'nama'              => ['required', 'string', 'max:255'],
            'kategori'          => ['required', 'string', 'max:255'],
            'rujukan_skkni'     => ['nullable', 'string', 'max:255'],
            'jumlah_unit'       => ['required', 'integer', 'min:0'],
            'estimasi_biaya'    => ['nullable', 'numeric', 'min:0'],
            'biaya'             => ['nullable', 'string', 'max:50'],
            'deskripsi_singkat' => ['nullable', 'string', 'max:255'],
            'ringkasan'         => ['nullable', 'string', ],
            'persyaratan_peserta' => ['nullable', 'string', ],
            'metode_asesmen'    => ['nullable', 'string'],
            'gambar'            => ['nullable', 'image', 'max:2048'],
            'file_panduan'      => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:4096'],
        ]);
    }
}
