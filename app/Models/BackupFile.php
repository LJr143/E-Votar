<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupFile extends Model
{
    protected $table = 'backup_files';
    protected $fillable = [
        'backup_schedule_id',
        'file_path',
        'file_size',
        'created_by',];
}
