<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PartyList extends Model
{

    use LogsActivity;
    protected $table = 'party_lists';

    protected $fillable = ['name', 'logo_path'];

    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class, 'party_list_id', 'id');
    }
}
