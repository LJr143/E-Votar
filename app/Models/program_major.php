<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class program_major extends Model
{

    use LogsActivity;
    protected $table = 'program_majors';

    protected $fillable = ['program_id', 'name'];

    public function program(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }
}
