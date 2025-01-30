<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaceRecognition extends Model
{
    protected $table = 'face_recognition';
    protected $fillable = ['use_id', 'face_descriptor'];
}
