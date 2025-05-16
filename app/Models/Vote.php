<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{

    protected $table = 'votes';
    protected $fillable = ['user_id','candidate_id', 'election_id', 'election_type_id', 'position_id'];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function election(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Election::class, 'election_id', 'id');
    }
   public function position(): \Illuminate\Database\Eloquent\Relations\BelongsTo
   {
       return $this->belongsTo(Position::class, 'position_id', 'id');
   }
}
