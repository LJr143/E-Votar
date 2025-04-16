<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackToken extends Model
{
    protected $fillable = ['user_id', 'election_id', 'token', 'used'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function election()
    {
        return $this->belongsTo(Election::class);
    }
}

