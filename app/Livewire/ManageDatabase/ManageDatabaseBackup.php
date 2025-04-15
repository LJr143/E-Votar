<?php

namespace App\Livewire\ManageDatabase;

use App\Models\BackupSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class ManageDatabaseBackup extends Component
{
    use WithPagination;

    public $search = '';
    public $filterDate = '';
    public $backupName = '';
    public $scheduleType = 'daily';
    public $customTime = '';
    public $dayOfWeek = 'monday';
    public $dayOfMonth = 1;

    protected $rules = [
        'backupName' => 'required|string|max:255|unique:backup_schedules,name',
        'scheduleType' => 'required|in:hourly,daily,weekly,monthly,custom',
        'customTime' => 'required_if:scheduleType,custom|date_format:H:i',
        'dayOfWeek' => 'required_if:scheduleType,weekly|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
        'dayOfMonth' => 'required_if:scheduleType,monthly|integer|between:1,31',
    ];

    protected $messages = [
        'backupName.unique' => 'This backup name is already in use.',
        'customTime.date_format' => 'The custom time must be in HH:MM format.',
        'dayOfMonth.between' => 'The day of month must be between 1 and 31.',
    ];

    public function mount()
    {
        Storage::disk('public')->makeDirectory('backups');
    }

    public function render()
    {
        $query = BackupSchedule::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->filterDate, fn($q) => $q->whereDate('created_at', $this->filterDate))
            ->withCount('backupFiles')
            ->with('backupFiles')
            ->orderBy('created_at', 'desc');

        return view('evotar.livewire.manage-database.manage-database-backup', [
            'backups' => $query->paginate(10),
            'daysOfWeek' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
        ]);
    }

    public function createBackupSchedule()
    {
        $this->validate();

        try {
            $nextBackup = $this->calculateNextBackupTime();

            BackupSchedule::create([
                'name' => $this->backupName,
                'schedule_type' => $this->scheduleType,
                'schedule_parameters' => $this->getScheduleParameters(),
                'next_backup_at' => $nextBackup,
                'last_backup_at' => null,
                'created_by' => auth()->user()->id ?? 34,
            ]);

            $this->resetForm();
            $this->dispatch('notify', ['type' => 'success', 'message' => 'Backup schedule created successfully!']);
        } catch (\Exception $e) {
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Failed to create schedule: ' . $e->getMessage()]);
        }
    }

    protected function calculateNextBackupTime()
    {
        $now = Carbon::now();

        return match ($this->scheduleType) {
            'hourly' => $now->addHour()->startOfHour(),
            'daily' => $now->addDay()->startOfDay(),
            'weekly' => $now->next($this->dayOfWeek)->startOfDay(),
            'monthly' => $this->calculateNextMonthlyBackup($now),
            'custom' => $now->setTimeFromTimeString($this->customTime)->startOfMinute(),
            default => $now->addDay()->startOfDay(),
        };
    }

    protected function calculateNextMonthlyBackup(Carbon $now)
    {
        $next = $now->copy()->addMonth()->day(min($this->dayOfMonth, $now->daysInMonth));
        return $next->isPast() ? $next->addMonth() : $next->startOfDay();
    }

    protected function getScheduleParameters()
    {
        return match ($this->scheduleType) {
            'weekly' => json_encode(['day_of_week' => $this->dayOfWeek]),
            'monthly' => json_encode(['day_of_month' => $this->dayOfMonth]),
            'custom' => json_encode(['custom_time' => $this->customTime]),
            default => json_encode([]),
        };
    }

    public function runBackupNow($backupId)
    {
        $backup = BackupSchedule::findOrFail($backupId);

        try {
            DB::transaction(function () use ($backup) {
                $filePath = $this->performBackup($backup);

                $backup->update([
                    'last_backup_at' => now(),
                    'next_backup_at' => $this->calculateNextBackupTimeForExisting($backup),
                ]);

                $backup->backupFiles()->create([
                    'file_path' => $filePath,
                    'file_size' => Storage::disk('public')->size($filePath),
                    'created_by' => auth()->id() ?? 1,
                ]);

                Log::info('Backup completed', [
                    'schedule_id' => $backup->id,
                    'file_path' => $filePath,
                    'size' => Storage::disk('public')->size($filePath),
                ]);
            });

            $this->dispatch('notify', ['type' => 'success', 'message' => 'Backup completed successfully!']);
        } catch (\Exception $e) {
            Log::error('Backup failed', ['error' => $e->getMessage()]);
            $this->dispatch('notify', ['type' => 'error', 'message' => 'Backup failed: ' . $e->getMessage()]);
        }
    }

    protected function performBackup(BackupSchedule $backup)
    {
        $filename = "backup-{$backup->name}-" . now()->format('Y-m-d-H-i-s') . '.sql';
        $filePath = "backups/{$filename}";
        $fullPath = storage_path("app/public/{$filePath}");

//        $mysqlDumpPath = 'C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysqldump.exe'; // Adjust version
        $mysqlDumpPath = 'mysqldump';

        $command = sprintf(
            '"%s" --user=%s --password=%s --host=%s --port=%s %s > "%s"',
            $mysqlDumpPath,
            escapeshellarg(config('database.connections.mysql.username')),
            escapeshellarg(config('database.connections.mysql.password')),
            escapeshellarg(config('database.connections.mysql.host')),
            escapeshellarg(config('database.connections.mysql.port')),
            escapeshellarg(config('database.connections.mysql.database')),
            $fullPath
        );

        exec($command, $output, $returnVar);

        if ($returnVar !== 0 || !file_exists($fullPath)) {
            throw new \Exception('Failed to create backup file. Exit code: ' . $returnVar);
        }

        return $filePath;
    }

    public function downloadBackupFile($backupFileId)
    {
        $backupFile = \App\Models\BackupFile::findOrFail($backupFileId);
        $filePath = $backupFile->file_path;

        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->download($filePath);
        }

        $this->dispatch('notify', ['type' => 'error', 'message' => 'Backup file not found.']);
    }

    protected function calculateNextBackupTimeForExisting(BackupSchedule $backup)
    {
        $this->scheduleType = $backup->schedule_type;
        $params = json_decode($backup->schedule_parameters, true) ?? [];
        $this->dayOfWeek = $params['day_of_week'] ?? 'monday';
        $this->dayOfMonth = $params['day_of_month'] ?? 1;
        $this->customTime = $params['custom_time'] ?? '00:00';

        $next = $this->calculateNextBackupTime();

        if ($this->scheduleType === 'custom' && $next->isPast()) {
            return Carbon::now()->setTimeFromTimeString($this->customTime)->addDay()->startOfMinute();
        }

        return $next;
    }

    public function deleteBackup($backupId)
    {
        $backup = BackupSchedule::findOrFail($backupId);
        $backup->delete();

        $this->dispatch('notify', ['type' => 'success', 'message' => 'Backup schedule deleted successfully!']);
    }

    protected function resetForm()
    {
        $this->reset(['backupName', 'scheduleType', 'customTime', 'dayOfWeek', 'dayOfMonth']);
        $this->scheduleType = 'daily';
        $this->dayOfMonth = 1;
    }
}
