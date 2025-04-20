<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{

    use LogsActivity;

    protected $table = 'campuses';
    protected $fillable = ['name'];

    public function colleges(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(College::class);
    }
}
