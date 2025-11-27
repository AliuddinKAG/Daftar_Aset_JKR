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

        // Numbers
        'kuantiti' => 'integer',
        'komponen_sama_jenis' => 'integer',
        'jangka_hayat' => 'integer',
        
        // JSON fields - AUTO DECODE
        'saiz' => 'array',
        'saiz_unit' => 'array',
        'kadaran' => 'array',
        'kadaran_unit' => 'array',
        'kapasiti' => 'array',
        'kapasiti_unit' => 'array',
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

    public function scopeByDiscipline($query, $discipline)
    {
        return $query->where($discipline, true);
    }

    /**
     * Accessors
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
}