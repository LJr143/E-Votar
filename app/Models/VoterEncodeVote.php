<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoterEncodeVote extends Model
{
    protected $table = 'voter_encode_votes';
    protected $fillable = ['user_id', 'election_id', 'encoded_image_path', 'encrypted_data'];

    protected $casts = [
        'encrypted_data' => 'array',
    ];
}
