<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartyList extends Model
{
    protected $table = 'party_lists';

    protected $fillable = ['name'];
}
