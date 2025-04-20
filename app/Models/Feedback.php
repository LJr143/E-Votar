<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use LogsActivity;
 protected $table = 'feedback';
 protected $fillable = ['token','user_id', 'name', 'email','rating', 'message'];
}
