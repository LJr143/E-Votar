<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbstainVote extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'election_id',
        'position_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function electionPosition()
    {
        return $this->belongsTo(ElectionPosition::class, 'position_id');
    }
}
