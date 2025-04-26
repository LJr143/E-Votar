<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetYearlyVerification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verification:reset';

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
        \App\Models\User::query()->update(['is_verified' => false]);
        $this->info('Yearly voter verification reset!');
    }
}
