<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sistem extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sistems';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the subsistems for this sistem.
     */
    public function subsistems()
    {
        return $this->hasMany(Subsistem::class, 'sistem_id');
    }

    /**
     * Get active subsistems only.
     */
    public function activeSubsistems()
    {
        return $this->hasMany(Subsistem::class, 'sistem_id')
                    ->where('is_active', true)
                    ->orderBy('kod');
    }

    /**
     * Scope a query to only include active sistems.
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
     * Scope to include subsistems count.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithSubsistemCount($query)
    {
        return $query->withCount('subsistems');
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
     * Check if this sistem has any subsistems.
     *
     * @return bool
     */
    public function hasSubsistems()
    {
        return $this->subsistems()->exists();
    }

    /**
     * Get subsistem options for dropdown.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSubsistemOptions()
    {
        return $this->activeSubsistems()
                    ->get()
                    ->pluck('full_name', 'kod');
    }
}