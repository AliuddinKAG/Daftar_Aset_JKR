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
     * Casts - JSON fields dan dates sahaja
     * BUANG saiz, kadaran, kapasiti dari casts kerana guna measurements table
     */
    protected $casts = [
        // JSON fields
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
     * ========================================
     * RELATIONSHIPS
     * ========================================
     */
    
    /**
     * Hubungan ke Komponen Utama
     */
    public function mainComponent(): BelongsTo
    {
        return $this->belongsTo(MainComponent::class, 'main_component_id');
    }

    /**
     * Get all measurements (ordered)
     */
    public function measurements()
    {
        return $this->hasMany(SubComponentMeasurement::class)->orderBy('order');
    }

    /**
     * Get saiz measurements only
     */
    public function saizMeasurements()
    {
        return $this->hasMany(SubComponentMeasurement::class)
            ->where('type', 'saiz')
            ->orderBy('order');
    }

    /**
     * Get kadaran measurements only
     */
    public function kadaranMeasurements()
    {
        return $this->hasMany(SubComponentMeasurement::class)
            ->where('type', 'kadaran')
            ->orderBy('order');
    }

    /**
     * Get kapasiti measurements only
     */
    public function kapasitiMeasurements()
    {
        return $this->hasMany(SubComponentMeasurement::class)
            ->where('type', 'kapasiti')
            ->orderBy('order');
    }

    /**
     * ========================================
     * MEASUREMENT HELPER METHODS
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
            return trim($m->value . ' ' . ($m->unit ?? ''));
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
            return trim($m->value . ' ' . ($m->unit ?? ''));
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
            return trim($m->value . ' ' . ($m->unit ?? ''));
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
     * SCOPES
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

    /**
     * ========================================
     * ACCESSORS
     * ========================================
     */
    
    public function getIsWarrantyExpiredAttribute()
    {
        return $this->tarikh_waranti_tamat?->isPast();
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