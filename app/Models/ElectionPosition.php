<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectionPosition extends Model
{
    protected $table = 'election_positions';

    protected $fillable = ['election_id', 'position_id'];
}
