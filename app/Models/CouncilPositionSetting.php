<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class CouncilPositionSetting extends Model
{

    use LogsActivity;
    protected $table = 'council_position_settings';
    protected $fillable = ['council_id', 'position_id', 'separate_by_major'];
}
