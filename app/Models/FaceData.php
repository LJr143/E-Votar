<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaceData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'angle',
        'image_path',
        'quality_score',
        'descriptor'
    ];

    protected $casts = [
        'descriptor' => 'array',
        'quality_score' => 'float'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
