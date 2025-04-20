<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{

    use LogsActivity;

    protected $fillable = [
        'title',
        'content',
        'publication_at',
        'cover_image',
        'media',
        'status',
    ];

    protected $casts = [
        'publication_at' => 'datetime',
        'media' => 'array', // Automatically decode JSON to array
        'status' => 'string',
    ];
}
