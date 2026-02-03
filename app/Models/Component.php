<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nama_premis',
        'nombor_dpa',
        'ada_blok',
        'kod_blok',
        'nama_blok',
        'kod_aras',
        'nama_aras',
        'kod_ruang',
        'nama_ruang',
        'catatan_blok',
        'ada_binaan_luar',
        'nama_binaan_luar',
        'kod_binaan_luar',
        'koordinat_x',
        'koordinat_y',
        'panjang',          // TAMBAH
        'lebar',            // TAMBAH
        'tinggi',           // TAMBAH
        'unit_ukuran',      // TAMBAH
        'kod_aras_binaan',
        'nama_aras_binaan',
        'kod_ruang_binaan',
        'nama_ruang_binaan',
        'catatan_binaan',
        'status'
    ];

    protected $casts = [
        'ada_blok' => 'boolean',
        'ada_binaan_luar' => 'boolean',
        'koordinat_x' => 'decimal:6',
        'koordinat_y' => 'decimal:6',
        'panjang' => 'decimal:2',      // TAMBAH
        'lebar' => 'decimal:2',        // TAMBAH
        'tinggi' => 'decimal:2',       // TAMBAH
        'deleted_at' => 'datetime',
    ];

    protected $appends = ['kod_lokasi', 'dimensi_string'];

    // Mutator untuk koordinat GPS sahaja
    public function setKoordinatXAttribute($value)
    {
        $this->attributes['koordinat_x'] = $this->cleanKoordinat($value);
    }
    
    public function setKoordinatYAttribute($value)
    {
        $this->attributes['koordinat_y'] = $this->cleanKoordinat($value);
    }
    
    /**
     * Bersihkan nilai koordinat GPS
     */
    private function cleanKoordinat($value)
    {
        if (empty($value)) {
            return null;
        }
        
        // Remove prefix macam "X:" atau "Y:"
        $value = preg_replace('/^[A-Za-z]+\s*:\s*/', '', trim($value));
        
        // Remove semua kecuali nombor, dot, dan minus
        $cleaned = preg_replace('/[^0-9.-]/', '', $value);
        
        return ($cleaned !== '' && is_numeric($cleaned)) ? $cleaned : null;
    }

    /**
     * Mutator untuk parse dimensi dari format "4000*1200*500"
     */
    public function setDimensiAttribute($value)
    {
        if (empty($value)) {
            return;
        }

        // Parse format "4000*1200*500" atau "4000x1200x500"
        $parts = preg_split('/[*xX×]/', $value);
        
        if (count($parts) >= 3) {
            $this->attributes['panjang'] = trim($parts[0]);
            $this->attributes['lebar'] = trim($parts[1]);
            $this->attributes['tinggi'] = trim($parts[2]);
        }
    }

    /**
     * Accessor untuk display dimensi sebagai string
     */
    public function getDimensiStringAttribute()
    {
        if ($this->panjang && $this->lebar && $this->tinggi) {
            return "{$this->panjang} × {$this->lebar} × {$this->tinggi} {$this->unit_ukuran}";
        }
        return null;
    }

    /**
     * Accessor untuk volum (jika diperlukan)
     */
    public function getVolumAttribute()
    {
        if ($this->panjang && $this->lebar && $this->tinggi) {
            return $this->panjang * $this->lebar * $this->tinggi;
        }
        return null;
    }

    public function getKodLokasiAttribute()
    {
        if ($this->ada_blok && $this->kod_blok) {
            $parts = array_filter([
                $this->kod_blok,
                $this->kod_aras,
                $this->kod_ruang
            ]);
            return implode('-', $parts);
        }
        
        if ($this->ada_binaan_luar && $this->kod_binaan_luar) {
            return $this->kod_binaan_luar;
        }
        
        return $this->nombor_dpa;
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeTidakAktif($query)
    {
        return $query->where('status', 'tidak_aktif');
    }
    /**
     * TAMBAH Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mainComponents()
    {
        return $this->hasMany(MainComponent::class);
    }

    /**
     * TAMBAH Scope untuk filter by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}