<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubComponent extends Model
{
    use HasFactory, SoftDeletes;

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
     * Casts - BUANG array cast untuk saiz, kadaran, kapasiti
     */
    protected $casts = [
        // JSON fields - hanya dokumen_berkaitan
        'dokumen_berkaitan' => 'array',
        
        // Dates
        'tarikh_pembelian' => 'date',
        'tarikh_dipasang' => 'date',
        'tarikh_waranti_tamat' => 'date',
        
        // Numbers
        'kuantiti' => 'integer',
        'kos_perolehan' => 'decimal:2',
    ];

    /**
     * Hubungan ke Komponen Utama
     */
    public function mainComponent(): BelongsTo
    {
        return $this->belongsTo(MainComponent::class, 'main_component_id');
    }

    /**
     * Scopes
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeTidakAktif($query)
    {
        return $query->where('status', 'tidak_aktif');
    }

    /**
     * Accessors
     */
    public function getIsWarrantyExpiredAttribute()
    {
        return $this->tarikh_waranti_tamat?->isPast();
    }

    /**
     * HELPER METHODS untuk display formatted values
     */
    
    /**
     * Get saiz with unit formatted - SIMPLE VERSION
     */
    public function getSaizFormatted()
    {
        $saiz = $this->saiz ?? '';
        $unit = $this->saiz_unit ?? '';
        
        if (empty($saiz)) {
            return '-';
        }
        
        return trim($saiz . ' ' . $unit);
    }

    /**
     * Get kadaran with unit formatted - SIMPLE VERSION
     */
    public function getKadaranFormatted()
    {
        $kadaran = $this->kadaran ?? '';
        $unit = $this->kadaran_unit ?? '';
        
        if (empty($kadaran)) {
            return '-';
        }
        
        return trim($kadaran . ' ' . $unit);
    }

    /**
     * Get kapasiti with unit formatted - SIMPLE VERSION
     */
    public function getKapasitiFormatted()
    {
        $kapasiti = $this->kapasiti ?? '';
        $unit = $this->kapasiti_unit ?? '';
        
        if (empty($kapasiti)) {
            return '-';
        }
        
        return trim($kapasiti . ' ' . $unit);
    }

    /**
     * Get saiz value - untuk edit form
     */
    public function getSaizValue()
    {
        return $this->saiz ?? '';
    }

    /**
     * Get saiz unit - untuk edit form
     */
    public function getSaizUnitValue()
    {
        return $this->saiz_unit ?? '';
    }

    /**
     * Get kadaran value - untuk edit form
     */
    public function getKadaranValue()
    {
        return $this->kadaran ?? '';
    }

    /**
     * Get kadaran unit - untuk edit form
     */
    public function getKadaranUnitValue()
    {
        return $this->kadaran_unit ?? '';
    }

    /**
     * Get kapasiti value - untuk edit form
     */
    public function getKapasitiValue()
    {
        return $this->kapasiti ?? '';
    }

    /**
     * Get kapasiti unit - untuk edit form
     */
    public function getKapasitiUnitValue()
    {
        return $this->kapasiti_unit ?? '';
    }

    /**
     * Get formatted documents list
     */
    public function getDokumenBerkaitanFormatted()
    {
        if (empty($this->dokumen_berkaitan)) {
            return [];
        }

        return is_array($this->dokumen_berkaitan) ? $this->dokumen_berkaitan : [];
    }
}