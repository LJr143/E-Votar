<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'programs';
    protected $fillable = ['college_id', 'name'];

    public function college(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function majors(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(program_major::class, 'program_id');
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }

    public function council(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
     return $this->belongsTo(Council::class);
    }

}
