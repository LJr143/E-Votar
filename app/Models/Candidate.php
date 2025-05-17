<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{

    use LogsActivity;
    protected $table = 'candidates';
    protected $fillable = ['user_id','election_id', 'election_position_id', 'party_list_id', 'description'];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function elections(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Election::class, 'election_id', 'id');
    }

    public function election_positions(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ElectionPosition::class, 'election_position_id', 'id');
    }

    public function votes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function partyLists(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PartyList::class, 'party_list_id', 'id');
    }
}
