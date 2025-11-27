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
     * Casts untuk auto-decode JSON dan date fields
     */
    protected $casts = [
        // JSON fields - AUTO DECODE
        'saiz' => 'array',
        'saiz_unit' => 'array',
        'kadaran' => 'array',
        'kadaran_unit' => 'array',
        'kapasiti' => 'array',
        'kapasiti_unit' => 'array',
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
     * Get saiz with unit formatted
     */
    public function getSaizFormatted()
    {
        if (empty($this->saiz)) {
            return '-';
        }

        // Jika array (multiple values)
        if (is_array($this->saiz) && is_array($this->saiz_unit)) {
            $result = [];
            foreach ($this->saiz as $index => $saiz) {
                $unit = $this->saiz_unit[$index] ?? '';
                $combined = trim($saiz . ' ' . $unit);
                if (!empty($combined)) {
                    $result[] = $combined;
                }
            }
            return !empty($result) ? implode(', ', $result) : '-';
        }
        
        // Jika single value
        $saiz = is_array($this->saiz) ? ($this->saiz[0] ?? '') : $this->saiz;
        $unit = is_array($this->saiz_unit) ? ($this->saiz_unit[0] ?? '') : $this->saiz_unit;
        
        $combined = trim($saiz . ' ' . $unit);
        return !empty($combined) ? $combined : '-';
    }

    /**
     * Get kadaran with unit formatted
     */
    public function getKadaranFormatted()
    {
        if (empty($this->kadaran)) {
            return '-';
        }

        // Jika array (multiple values)
        if (is_array($this->kadaran) && is_array($this->kadaran_unit)) {
            $result = [];
            foreach ($this->kadaran as $index => $kadaran) {
                $unit = $this->kadaran_unit[$index] ?? '';
                $combined = trim($kadaran . ' ' . $unit);
                if (!empty($combined)) {
                    $result[] = $combined;
                }
            }
            return !empty($result) ? implode(', ', $result) : '-';
        }
        
        // Jika single value
        $kadaran = is_array($this->kadaran) ? ($this->kadaran[0] ?? '') : $this->kadaran;
        $unit = is_array($this->kadaran_unit) ? ($this->kadaran_unit[0] ?? '') : $this->kadaran_unit;
        
        $combined = trim($kadaran . ' ' . $unit);
        return !empty($combined) ? $combined : '-';
    }

    /**
     * Get kapasiti with unit formatted
     */
    public function getKapasitiFormatted()
    {
        if (empty($this->kapasiti)) {
            return '-';
        }

        // Jika array (multiple values)
        if (is_array($this->kapasiti) && is_array($this->kapasiti_unit)) {
            $result = [];
            foreach ($this->kapasiti as $index => $kapasiti) {
                $unit = $this->kapasiti_unit[$index] ?? '';
                $combined = trim($kapasiti . ' ' . $unit);
                if (!empty($combined)) {
                    $result[] = $combined;
                }
            }
            return !empty($result) ? implode(', ', $result) : '-';
        }
        
        // Jika single value
        $kapasiti = is_array($this->kapasiti) ? ($this->kapasiti[0] ?? '') : $this->kapasiti;
        $unit = is_array($this->kapasiti_unit) ? ($this->kapasiti_unit[0] ?? '') : $this->kapasiti_unit;
        
        $combined = trim($kapasiti . ' ' . $unit);
        return !empty($combined) ? $combined : '-';
    }

    /**
     * Get saiz value only (without unit) - untuk edit form
     */
    public function getSaizValue()
    {
        if (empty($this->saiz)) {
            return '';
        }
        
        if (is_array($this->saiz)) {
            return $this->saiz[0] ?? '';
        }
        
        return $this->saiz;
    }

    /**
     * Get saiz unit only - untuk edit form
     */
    public function getSaizUnitValue()
    {
        if (empty($this->saiz_unit)) {
            return '';
        }
        
        if (is_array($this->saiz_unit)) {
            return $this->saiz_unit[0] ?? '';
        }
        
        return $this->saiz_unit;
    }

    /**
     * Get kadaran value only (without unit) - untuk edit form
     */
    public function getKadaranValue()
    {
        if (empty($this->kadaran)) {
            return '';
        }
        
        if (is_array($this->kadaran)) {
            return $this->kadaran[0] ?? '';
        }
        
        return $this->kadaran;
    }

    /**
     * Get kadaran unit only - untuk edit form
     */
    public function getKadaranUnitValue()
    {
        if (empty($this->kadaran_unit)) {
            return '';
        }
        
        if (is_array($this->kadaran_unit)) {
            return $this->kadaran_unit[0] ?? '';
        }
        
        return $this->kadaran_unit;
    }

    /**
     * Get kapasiti value only (without unit) - untuk edit form
     */
    public function getKapasitiValue()
    {
        if (empty($this->kapasiti)) {
            return '';
        }
        
        if (is_array($this->kapasiti)) {
            return $this->kapasiti[0] ?? '';
        }
        
        return $this->kapasiti;
    }

    /**
     * Get kapasiti unit only - untuk edit form
     */
    public function getKapasitiUnitValue()
    {
        if (empty($this->kapasiti_unit)) {
            return '';
        }
        
        if (is_array($this->kapasiti_unit)) {
            return $this->kapasiti_unit[0] ?? '';
        }
        
        return $this->kapasiti_unit;
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