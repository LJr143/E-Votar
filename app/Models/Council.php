<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Council extends Model
{
    protected $table = 'councils';
    protected $fillable = [
        'name', 'program_id'
    ];

    public function program(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function councilPositionSetting(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CouncilPositionSetting::class, 'council_id');
    }
}
