<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_component_id',
        'bil',
        'nama_dokumen',
        'no_rujukan_berkaitan',
        'catatan',
        'file_path',
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