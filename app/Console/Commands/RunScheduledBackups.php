<?php

namespace App\Console\Commands;

use App\Livewire\ManageDatabase\ManageDatabaseBackup;
use App\Models\BackupSchedule;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RunScheduledBackups extends Command
{
    protected $signature = 'backups:run';
    protected $description = 'Run scheduled database backups';

    public function handle()
    {
        $now = Carbon::now();
        $schedules = BackupSchedule::where('next_backup_at', '<=', $now)->get();

        if ($schedules->isEmpty()) {
            $this->info('No backups due at this time.');
            return;
        }

        $component = new ManageDatabaseBackup();

        foreach ($schedules as $backup) {
            try {
                $component->runBackupNow($backup->id);
                $this->info("Backup completed for: {$backup->name}");
            } catch (\Exception $e) {
                Log::error('Scheduled backup failed', [
                    'schedule_id' => $backup->id,
                    'error' => $e->getMessage(),
                ]);
                $this->error("Backup failed for: {$backup->name} - {$e->getMessage()}");
            }
        }
    }
}
