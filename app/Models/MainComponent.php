<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainComponent extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass Assignment - fillable untuk keselamatan
     */
    protected $fillable = [
        'component_id', 'nama_komponen_utama', 'kod_lokasi', 'sistem', 'subsistem',
        'kuantiti', 'komponen_sama_jenis', 'gambar_komponen', 'awam_arkitek',
        'elektrikal', 'elv_ict', 'mekanikal', 'bio_perubatan', 'lain_lain',
        'catatan', 'tarikh_perolehan', 'kos_perolehan', 'no_pesanan_rasmi_kontrak',
        'tarikh_dipasang', 'tarikh_waranti_tamat',
        'tarikh_tamat_dlp', 'jangka_hayat', 'nama_pengilang', 'nama_pembekal',
        'alamat_pembekal', 'no_telefon_pembekal', 'nama_kontraktor',
        'alamat_kontraktor', 'no_telefon_kontraktor', 'catatan_maklumat',
        'deskripsi', 'status_komponen', 'jenama', 'model', 'no_siri',
        'no_tag_label', 'no_sijil_pendaftaran', 'jenis', 'bekalan_elektrik',
        'bahan', 'kaedah_pemasangan', 'saiz', 'saiz_unit', 'kadaran', 'kadaran_unit',
        'kapasiti', 'kapasiti_unit', 'catatan_atribut', 'catatan_komponen_berhubung',
        'catatan_dokumen', 'nota', 'status'
    ];

    /**
     * Casts — untuk tarikh dan boolean sahaja
     * NOTA: saiz, kadaran, kapasiti adalah STRING kerana boleh ada multiple values
     */
    protected $casts = [
        // Discipline flags
        'awam_arkitek' => 'boolean',
        'elektrikal' => 'boolean',
        'elv_ict' => 'boolean',
        'mekanikal' => 'boolean',
        'bio_perubatan' => 'boolean',

        // Dates
        'tarikh_perolehan' => 'date',
        'tarikh_dipasang' => 'date',
        'tarikh_waranti_tamat' => 'date',
        'tarikh_tamat_dlp' => 'date',

        // Numbers - hanya yang betul-betul number
        'kuantiti' => 'integer',
        'komponen_sama_jenis' => 'integer',
        'jangka_hayat' => 'integer',
        
        // TIDAK cast saiz, kadaran, kapasiti kerana boleh ada format seperti "1200x400x500"
    ];

    /**
     * Relationships
     */
    public function component()
    {
        return $this->belongsTo(Component::class);
    }

    public function subComponents()
    {
        return $this->hasMany(SubComponent::class, 'main_component_id')
            ->orderBy('nama_sub_komponen');
    }

    public function relatedComponents()
    {
        return $this->hasMany(RelatedComponent::class);
    }

    public function relatedDocuments()
    {
        return $this->hasMany(RelatedDocument::class);
    }

    /**
     * ========================================
     * MEASUREMENTS RELATIONSHIPS (NEW)
     * ========================================
     */
    
    /**
     * Get all measurements (ordered)
     */
    public function measurements()
    {
        return $this->hasMany(MainComponentMeasurement::class)->orderBy('order');
    }

    /**
     * Get saiz measurements only
     */
    public function saizMeasurements()
    {
        return $this->measurements()->where('type', 'saiz');
    }

    /**
     * Get kadaran measurements only
     */
    public function kadaranMeasurements()
    {
        return $this->measurements()->where('type', 'kadaran');
    }

    /**
     * Get kapasiti measurements only
     */
    public function kapasitiMeasurements()
    {
        return $this->measurements()->where('type', 'kapasiti');
    }

    /**
     * ========================================
     * MEASUREMENT HELPER METHODS (NEW)
     * ========================================
     */

    /**
     * Get formatted saiz (all values with units)
     * Returns: "1200x400x500 mm, 800 cm"
     */
    public function getSaizFormattedAttribute(): string
    {
        $measurements = $this->saizMeasurements;
        
        if ($measurements->isEmpty()) {
            return '-';
        }

        return $measurements->map(function ($m) {
            return trim($m->value . ' ' . $m->unit);
        })->implode(', ');
    }

    /**
     * Get formatted kadaran (all values with units)
     * Returns: "15 kW, 20 HP"
     */
    public function getKadaranFormattedAttribute(): string
    {
        $measurements = $this->kadaranMeasurements;
        
        if ($measurements->isEmpty()) {
            return '-';
        }

        return $measurements->map(function ($m) {
            return trim($m->value . ' ' . $m->unit);
        })->implode(', ');
    }

    /**
     * Get formatted kapasiti (all values with units)
     * Returns: "2000 L, 1.5 ton"
     */
    public function getKapasitiFormattedAttribute(): string
    {
        $measurements = $this->kapasitiMeasurements;
        
        if ($measurements->isEmpty()) {
            return '-';
        }

        return $measurements->map(function ($m) {
            return trim($m->value . ' ' . $m->unit);
        })->implode(', ');
    }

    /**
     * Get all measurements grouped by type
     * Returns: ['saiz' => [...], 'kadaran' => [...], 'kapasiti' => [...]]
     */
    public function getMeasurementsByTypeAttribute(): array
    {
        return [
            'saiz' => $this->saizMeasurements,
            'kadaran' => $this->kadaranMeasurements,
            'kapasiti' => $this->kapasitiMeasurements,
        ];
    }

    /**
     * Check if has any measurements
     */
    public function hasMeasurements(): bool
    {
        return $this->measurements()->exists();
    }

    /**
     * ========================================
     * EXISTING SCOPES
     * ========================================
     */
    
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeTidakAktif($query)
    {
        return $query->where('status', 'tidak_aktif');
    }

    public function scopeByDiscipline($query, $discipline)
    {
        return $query->where($discipline, true);
    }

    /**
     * ========================================
     * EXISTING ACCESSORS
     * ========================================
     */
    
    public function getIsWarrantyExpiredAttribute()
    {
        return $this->tarikh_waranti_tamat?->isPast();
    }

    public function getIsDlpExpiredAttribute()
    {
        return $this->tarikh_tamat_dlp?->isPast();
    }

    public function getUmurAttribute()
    {
        return $this->tarikh_dipasang
            ? $this->tarikh_dipasang->diffInYears(now())
            : null;
    }

    /**
     * Get bidang kejuruteraan as array
     */
    public function getBidangKejuruteraanAttribute(): array
    {
        $bidang = [];
        
        if ($this->awam_arkitek) $bidang[] = 'Awam/Arkitek';
        if ($this->elektrikal) $bidang[] = 'Elektrikal';
        if ($this->elv_ict) $bidang[] = 'ELV/ICT';
        if ($this->mekanikal) $bidang[] = 'Mekanikal';
        if ($this->bio_perubatan) $bidang[] = 'Bio Perubatan';
        if ($this->lain_lain) $bidang[] = $this->lain_lain;
        
        return $bidang;
    }

    /**
     * Get bidang kejuruteraan as string
     */
    public function getBidangKejuruteraanStringAttribute(): string
    {
        return implode(', ', $this->bidang_kejuruteraan);
    }
}