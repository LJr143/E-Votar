<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectionExcludedVoter extends Model
{
    protected $table = 'election_excluded_voters';
    protected $fillable = ['user_id', 'election_id'];
}
