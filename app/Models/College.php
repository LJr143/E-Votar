<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{

    use LogsActivity;
    protected $table = 'colleges';
    protected $fillable = ['campus_id', 'name'];

    public function campus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }

    public function programs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Program::class);
    }
}
