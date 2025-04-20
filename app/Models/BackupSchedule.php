<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class BackupSchedule extends Model
{

    use LogsActivity;

    protected $table = 'backup_schedules';
    protected $fillable = ['name', 'schedule_type', 'schedule_parameters', 'next_backup_at', 'last_backup_at', 'created_by'];

    protected $casts = [
        'schedule_parameters' => 'array',
        'next_backup_at' => 'datetime', // Cast to Carbon
        'last_backup_at' => 'datetime', // Cast to Carbon
    ];

    public function backupFiles()
    {
        return $this->hasMany(BackupFile::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
