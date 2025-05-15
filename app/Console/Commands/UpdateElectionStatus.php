<?php

namespace App\Console\Commands;

use App\Models\Election;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateElectionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elections:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        // Update elections where date_started <= now AND status is "upcoming"
        Election::where('date_started', '<=', $now)
            ->where('status', 'pending')
            ->orWhere('status', 'active')
            ->update(['status' => 'ongoing']);

        Election::where('date_started', '>', $now)
            ->where('status', 'active')
            ->update(['status' => 'pending']);

        // Optional: Also mark elections as "completed" when date_ended is passed
        Election::where('date_ended', '<', $now)
            ->where('status', 'ongoing')
            ->update(['status' => 'completed']);

        Election::where('date_ended', '>', $now)
            ->where('status', 'completed')
            ->update(['status' => 'ongoing']);

        $this->info('Election statuses updated successfully.');
    }
}
