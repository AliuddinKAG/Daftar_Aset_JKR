<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubComponent extends Model
{
    protected $table = 'sub_components';

    protected $fillable = [
    'main_component_id',
    'nama_sub_komponen',
    'deskripsi',
    'status_komponen',
    'no_siri',
    'no_sijil_pendaftaran',
    'jenama',
    'model',
    'kuantiti',
    'catatan',
    'jenis',
    'bahan',
    'saiz',
    'saiz_unit',
    'kadaran',
    'kadaran_unit',
    'kapasiti',
    'kapasiti_unit',
    'catatan_atribut',
    'tarikh_pembelian',
    'kos_perolehan',
    'no_pesanan_rasmi_kontrak',
    'kod_ptj',
    'tarikh_dipasang',
    'tarikh_waranti_tamat',
    'jangka_hayat',
    'nama_pengilang',
    'nama_pembekal',
    'alamat_pembekal',
    'no_telefon_pembekal',
    'nama_kontraktor',
    'alamat_kontraktor',
    'no_telefon_kontraktor',
    'catatan_pembelian',
    'dokumen_berkaitan',
    'catatan_dokumen',
    'nota',
    'status',
    ];

    /**
     * Hubungan ke Komponen Utama
     */
    public function mainComponent(): BelongsTo
    {
        return $this->belongsTo(MainComponent::class, 'main_component_id');
    }
}
