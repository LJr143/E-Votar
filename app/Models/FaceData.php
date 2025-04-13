<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaceData extends Model
{

    protected $fillable = [
        'user_id',
        'angle',
        'expression',
        'image_path',
        'quality_score',
        'descriptor',
        'landmarks'
    ];

    protected $casts = [
        'descriptor' => 'array',
        'landmarks' => 'array'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
