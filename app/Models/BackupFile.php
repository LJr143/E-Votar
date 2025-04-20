<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class BackupFile extends Model
{

    use LogsActivity;

    protected $table = 'backup_files';
    protected $fillable = [
        'backup_schedule_id',
        'file_path',
        'file_size',
        'created_by',];

    public function backupSchedule(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(BackupSchedule::class);
    }
}
