<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitKompetensi extends Model
{
     protected $fillable = [
        'program_pelatihan_id',
        'no_urut',
        'kode_unit',
        'judul_unit',
    ];

    public function program()
    {
        return $this->belongsTo(ProgramPelatihan::class, 'program_pelatihan_id');
    }

    public function elemenKompetensis()
    {
        return $this->hasMany(ElemenKompetensi::class)->orderBy('no_urut');
    }
}
