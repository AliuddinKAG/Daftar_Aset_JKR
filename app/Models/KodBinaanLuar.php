<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KodBinaanLuar extends Model
{
    use SoftDeletes;

    protected $table = 'kod_binaan_luar';

    protected $fillable = [
        'kod',
        'nama',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Scope untuk filter active records
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope untuk filter inactive records
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'tidak_aktif');
    }
}