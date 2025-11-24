<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubComponentDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_component_id',   // ID hubungan ke jadual sub_component
        'nama_fail',          // Nama fail asal
        'path',               // Lokasi fail disimpan (contoh: storage/app/public/documents)
        'jenis_fail',         // Contoh: pdf, jpg, docx
        'catatan',            // Catatan tambahan
    ];

    /**
     * Hubungan ke model SubComponent
     */
    public function subComponent()
    {
        return $this->belongsTo(SubComponent::class);
    }
}
