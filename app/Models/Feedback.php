<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
 protected $table = 'feedback';
 protected $fillable = ['token','user_id', 'name', 'email','rating', 'message'];
}
