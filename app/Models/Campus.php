<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class campus extends Model
{
    protected $table = 'campuses';
    protected $fillable = ['name'];

    public function colleges(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(College::class);
    }
}
