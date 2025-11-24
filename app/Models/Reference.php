<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Kod Blok Model
class KodBlok extends Model
{
    protected $fillable = ['kod', 'nama', 'keterangan', 'is_active'];
    
    protected $casts = ['is_active' => 'boolean'];
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

// Kod Aras Model
class KodAras extends Model
{
    protected $table = 'kod_aras';
    
    protected $fillable = ['kod', 'nama', 'tingkat', 'is_active'];
    
    protected $casts = [
        'is_active' => 'boolean',
        'tingkat' => 'integer',
    ];
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('tingkat');
    }
}

// Kod Ruang Model
class KodRuang extends Model
{
    protected $fillable = ['kod', 'nama', 'kategori', 'is_active'];
    
    protected $casts = ['is_active' => 'boolean'];
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}

// Nama Ruang Model
class NamaRuang extends Model
{
    protected $fillable = ['nama', 'jenis', 'is_active'];
    
    protected $casts = ['is_active' => 'boolean'];
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis', $jenis);
    }
}

// Sistem Model
class Sistem extends Model
{
    protected $fillable = ['kod', 'nama', 'keterangan', 'is_active'];
    
    protected $casts = ['is_active' => 'boolean'];
    
    public function subsistems()
    {
        return $this->hasMany(Subsistem::class);
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

// SubSistem Model
class Subsistem extends Model
{
    protected $fillable = ['sistem_id', 'kod', 'nama', 'keterangan', 'is_active'];
    
    protected $casts = ['is_active' => 'boolean'];
    
    public function sistem()
    {
        return $this->belongsTo(Sistem::class);
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeBySistem($query, $sistemId)
    {
        return $query->where('sistem_id', $sistemId);
    }
}