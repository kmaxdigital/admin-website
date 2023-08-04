<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
//use Log;
use Illuminate\Support\Facades\Log;


class TestCronJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Cron:TestCron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command is for testing Cron Job';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
                Log::info('My KMAX cron job is running every minute.');
    }
}
