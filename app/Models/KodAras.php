<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodAras extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kod_aras';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kod',
        'nama',
        'tingkat',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tingkat' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include active kod aras.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->orderBy('tingkat');
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
     * Scope to filter by tingkat range.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $min
     * @param  int  $max
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByTingkatRange($query, $min, $max)
    {
        return $query->whereBetween('tingkat', [$min, $max]);
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
     * Check if this is ground floor or above.
     *
     * @return bool
     */
    public function isGroundOrAbove()
    {
        return $this->tingkat >= 0;
    }

    /**
     * Check if this is basement.
     *
     * @return bool
     */
    public function isBasement()
    {
        return $this->tingkat < 0;
    }
}