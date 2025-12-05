<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class KodBlok extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kod_bloks';

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
        'status', // Support both is_active and status columns
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
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that should be appended to model arrays.
     *
     * @var array
     */
    protected $appends = ['full_name'];

    /**
     * Scope a query to only include active kod blok.
     * Supports both is_active (boolean) and status (string) columns.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        // Check which column exists and use appropriate filter
        if (Schema::hasColumn($this->getTable(), 'status')) {
            return $query->where('status', 'aktif')->orderBy('kod');
        }
        
        return $query->where('is_active', true)->orderBy('kod');
    }

    /**
     * Scope a query to only include inactive kod blok.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        if (Schema::hasColumn($this->getTable(), 'status')) {
            return $query->where('status', 'tidak_aktif')->orderBy('kod');
        }
        
        return $query->where('is_active', false)->orderBy('kod');
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
        if (empty($search)) {
            return $query;
        }

        return $query->where(function($q) use ($search) {
            $q->where('kod', 'like', "%{$search}%")
              ->orWhere('nama', 'like', "%{$search}%")
              ->orWhere('keterangan', 'like', "%{$search}%");
        });
    }

    /**
     * Scope to order by kod
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $direction
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByKod($query, $direction = 'asc')
    {
        return $query->orderBy('kod', $direction);
    }

    /**
     * Get the full display name (kod + nama).
     * This is an accessor that can be used in views.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->kod . ' - ' . $this->nama;
    }

    /**
     * Get formatted display for dropdown
     *
     * @return string
     */
    public function getDisplayLabelAttribute()
    {
        $label = $this->full_name;
        
        if ($this->keterangan) {
            $label .= " ({$this->keterangan})";
        }
        
        return $label;
    }

    /**
     * Check if this kod is active
     * Supports both is_active and status columns
     *
     * @return bool
     */
    public function isActive()
    {
        if (Schema::hasColumn($this->getTable(), 'status')) {
            return $this->status === 'aktif';
        }
        
        return $this->is_active === true;
    }

    /**
     * Check if kod already exists (for validation)
     * Excludes the current record if ID is provided
     *
     * @param  string  $kod
     * @param  int|null  $excludeId
     * @return bool
     */
    public static function kodExists($kod, $excludeId = null)
    {
        $query = self::where('kod', $kod);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }

    /**
     * Get kod by search term
     *
     * @param  string  $search
     * @param  int  $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function searchKod($search, $limit = 10)
    {
        return self::active()
            ->search($search)
            ->limit($limit)
            ->get();
    }

    /**
     * Get all active kod for dropdown
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getForDropdown()
    {
        return self::active()->get()->pluck('full_name', 'kod');
    }

    /**
     * Relationship: Components using this kod blok
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function components()
    {
        return $this->hasMany(Component::class, 'kod_blok', 'kod');
    }

    /**
     * Get count of components using this kod
     *
     * @return int
     */
    public function getComponentCountAttribute()
    {
        return $this->components()->count();
    }

    /**
     * Check if kod can be deleted (not used by any component)
     *
     * @return bool
     */
    public function canBeDeleted()
    {
        return $this->component_count === 0;
    }

    /**
     * Activate this kod blok
     *
     * @return bool
     */
    public function activate()
    {
        if (Schema::hasColumn($this->getTable(), 'status')) {
            return $this->update(['status' => 'aktif']);
        }
        
        return $this->update(['is_active' => true]);
    }

    /**
     * Deactivate this kod blok
     *
     * @return bool
     */
    public function deactivate()
    {
        if (Schema::hasColumn($this->getTable(), 'status')) {
            return $this->update(['status' => 'tidak_aktif']);
        }
        
        return $this->update(['is_active' => false]);
    }

    /**
     * Boot method to register model events
     */
    protected static function boot()
    {
        parent::boot();

        // Before deleting, check if used by components
        static::deleting(function ($kodBlok) {
            if (!$kodBlok->canBeDeleted()) {
                throw new \Exception(
                    "Cannot delete Kod Blok '{$kodBlok->kod}'. " .
                    "It is currently being used by {$kodBlok->component_count} component(s)."
                );
            }
        });
    }
}