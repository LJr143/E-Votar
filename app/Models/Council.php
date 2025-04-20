<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Council extends Model
{

    use LogsActivity;
    protected $table = 'councils';
    protected $fillable = [
        'name', 'logo_path'
    ];

    public function program(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Program::class, 'id');
    }

    public function councilPositionSetting(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CouncilPositionSetting::class, 'council_id');
    }
}
