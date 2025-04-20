<?php

namespace App\Console\Commands;

use App\Models\Announcement;
use App\Models\Election;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PublishAnnouncement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish-announcement';

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
        Announcement::where('publication_at', '<=', $now)
            ->where('status', 'draft')
            ->update(['status' => 'published']);

        $this->info('Announcement statuses updated successfully.');
    }
}
