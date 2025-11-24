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
        'kod_sub_komponen',
        'jenis_sub_komponen',
        'kuantiti',
        'saiz',
        'saiz_unit',
        'kadaran',
        'kadaran_unit',
        'kapasiti',
        'kapasiti_unit',
        'jenama',
        'model',
        'no_siri',
        'tarikh_pemasangan',
        'tarikh_penyelenggaraan',
        'status',
        'catatan',
    ];

    /**
     * Hubungan ke Komponen Utama
     */
    public function mainComponent(): BelongsTo
    {
        return $this->belongsTo(MainComponent::class, 'main_component_id');
    }
}
