<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * SubComponentMeasurement Model
 * 
 * Handles measurements for sub components (saiz, kadaran, kapasiti)
 */
class SubComponentMeasurement extends Model
{
    protected $table = 'sub_component_measurements';

    protected $fillable = [
        'sub_component_id',
        'type',
        'value',
        'unit',
        'order'
    ];

    /**
     * Relationship: Belongs to SubComponent
     */
    public function subComponent()
    {
        return $this->belongsTo(SubComponent::class);
    }

    /**
     * Scope: Filter by measurement type
     * Usage: SubComponentMeasurement::ofType('kadaran')->get()
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type)->orderBy('order');
    }

    /**
     * Scope: Order by sequence
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get formatted value with unit
     * Returns: "800 cm" or "2000 L"
     */
    public function getFormattedAttribute(): string
    {
        if (empty($this->value)) {
            return '-';
        }

        return trim($this->value . ' ' . ($this->unit ?? ''));
    }

    /**
     * Check if measurement has unit
     */
    public function hasUnit(): bool
    {
        return !empty($this->unit);
    }

    /**
     * Get display name for type
     */
    public function getTypeDisplayAttribute(): string
    {
        return match($this->type) {
            'saiz' => 'Saiz Fizikal',
            'kadaran' => 'Kadaran',
            'kapasiti' => 'Kapasiti',
            default => ucfirst($this->type)
        };
    }
}