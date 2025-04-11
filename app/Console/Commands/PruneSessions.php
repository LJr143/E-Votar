<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PruneSessions extends Command
{
    protected $signature = 'session:clean';
    protected $description = 'Deletes expired sessions from the database';

    public function handle(): void
    {
        $lifetime = config('session.lifetime', 5) * 60;
        $expiredTime = time() - $lifetime;

        DB::table('sessions')->where('last_activity', '<', $expiredTime)->delete();

        $this->info('Expired sessions pruned successfully.');
    }
}
