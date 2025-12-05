<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class NamaRuang extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nama_ruangs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'jenis',
        'is_active',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include active nama ruang.
     * Supports both 'status' and 'is_active' columns for backward compatibility.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        if (Schema::hasColumn($this->getTable(), 'status')) {
            return $query->where('status', 'aktif')->orderBy('nama');
        }
        return $query->where('is_active', true)->orderBy('nama');
    }

    /**
     * Scope a query to search by nama.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('nama', 'like', "%{$search}%");
    }

    /**
     * Scope a query to filter by jenis.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $jenis
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis', $jenis);
    }

    /**
     * Scope to get office type rooms.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfficeRooms($query)
    {
        return $query->where('jenis', 'Office');
    }

    /**
     * Scope to get meeting rooms.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMeetingRooms($query)
    {
        return $query->where('jenis', 'Meeting');
    }

    /**
     * Scope to get facilities.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFacilities($query)
    {
        return $query->where('jenis', 'Facilities');
    }

    /**
     * Check if a nama already exists.
     *
     * @param  string  $nama
     * @return bool
     */
    public static function namaExists($nama)
    {
        return self::where('nama', $nama)->exists();
    }

    /**
     * Get all unique jenis (types).
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getJenis()
    {
        return self::where('is_active', true)
                   ->distinct()
                   ->pluck('jenis')
                   ->filter()
                   ->sort()
                   ->values();
    }

    /**
     * Get nama ruangs grouped by jenis.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function groupedByJenis()
    {
        return self::active()
                   ->get()
                   ->groupBy('jenis')
                   ->sortKeys();
    }
}