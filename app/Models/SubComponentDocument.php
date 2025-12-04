<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// OPTION A: If you have deleted_at column, use SoftDeletes
use Illuminate\Database\Eloquent\SoftDeletes;

class SubComponentDocument extends Model
{
    use HasFactory, SoftDeletes; // Remove SoftDeletes if no deleted_at column

    /**
     * IMPORTANT: Specify exact table name
     */
    protected $table = 'sub_component_documents';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'sub_component_id',
        'bil',
        'nama_dokumen',
        'no_rujukan_berkaitan',
        'catatan',
        'file_path',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'deleted_at' => 'datetime', // Remove this if not using SoftDeletes
    ];

    /**
     * Relationship: Belongs to SubComponent
     */
    public function subComponent()
    {
        return $this->belongsTo(SubComponent::class, 'sub_component_id', 'id');
    }
}