<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class election_type extends Model
{

    protected $table = 'election_types';

    public function elections(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Election::class);
    }
    public function positions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Position::class);
    }
}
