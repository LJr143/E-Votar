<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class ElectionPosition extends Model
{

    protected $table = 'election_positions';

    protected $fillable = ['election_id', 'position_id'];


    public function position(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function candidates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Candidate::class, 'election_position_id');
    }

    public function election(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Election::class, 'election_id');
    }
    public function abstainVotes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AbstainVote::class, 'position_id');
    }
}
