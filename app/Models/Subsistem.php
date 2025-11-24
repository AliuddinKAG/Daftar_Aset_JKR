<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsistem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subsistems';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sistem_id',
        'kod',
        'nama',
        'keterangan',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sistem_id' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the sistem that owns the subsistem.
     */
    public function sistem()
    {
        return $this->belongsTo(Sistem::class, 'sistem_id');
    }

    /**
     * Scope a query to only include active subsistems.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->orderBy('kod');
    }

    /**
     * Scope a query to search by kod or nama.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('kod', 'like', "%{$search}%")
              ->orWhere('nama', 'like', "%{$search}%");
        });
    }

    /**
     * Scope a query to filter by sistem.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $sistemId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBySistem($query, $sistemId)
    {
        return $query->where('sistem_id', $sistemId);
    }

    /**
     * Scope to include sistem data.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithSistem($query)
    {
        return $query->with('sistem');
    }

    /**
     * Get the full display name (kod + nama).
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->kod . ' - ' . $this->nama;
    }

    /**
     * Get the full display with sistem name.
     *
     * @return string
     */
    public function getFullNameWithSistemAttribute()
    {
        $sistemNama = $this->sistem ? $this->sistem->kod : 'N/A';
        return $sistemNama . ' > ' . $this->kod . ' - ' . $this->nama;
    }

    /**
     * Check if subsistem belongs to specific sistem kod.
     *
     * @param  string  $sistemKod
     * @return bool
     */
    public function belongsToSistem($sistemKod)
    {
        return $this->sistem && $this->sistem->kod === $sistemKod;
    }

    /**
     * Scope to get HVAC subsistems.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHvac($query)
    {
        return $query->whereHas('sistem', function($q) {
            $q->where('kod', 'HVAC');
        });
    }

    /**
     * Scope to get Electrical subsistems.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeElectrical($query)
    {
        return $query->whereHas('sistem', function($q) {
            $q->where('kod', 'ELEC');
        });
    }

    /**
     * Scope to get Fire Protection subsistems.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFireProtection($query)
    {
        return $query->whereHas('sistem', function($q) {
            $q->where('kod', 'FIRE');
        });
    }
}