<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * MainComponentMeasurement Model
 * 
 * Handles measurements for main components (saiz, kadaran, kapasiti)
 */
class MainComponentMeasurement extends Model
{
    protected $table = 'main_component_measurements';

    protected $fillable = [
        'main_component_id',
        'type',
        'value',
        'unit',
        'order'
    ];

    /**
     * Relationship: Belongs to MainComponent
     */
    public function mainComponent()
    {
        return $this->belongsTo(MainComponent::class);
    }

    /**
     * Scope: Filter by measurement type
     * Usage: MainComponentMeasurement::ofType('saiz')->get()
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
     * Returns: "1200x400x500 mm" or "15 kW"
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