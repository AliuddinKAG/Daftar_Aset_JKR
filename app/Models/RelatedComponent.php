<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_component_id',
        'bil',
        'nama_komponen',
        'no_dpa_kod_ruang',
        'no_tag_label',
    ];

    protected $casts = [
        'bil' => 'integer',
    ];

    /**
     * Relationship: Belongs to MainComponent
     */
    public function mainComponent()
    {
        return $this->belongsTo(MainComponent::class);
    }
}