<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PartyList extends Model
{
    protected $table = 'party_lists';

    protected $fillable = ['name'];

    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class, 'party_list_id', 'id');
    }
}
