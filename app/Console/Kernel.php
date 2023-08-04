<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        Commands\TaskCron::class,
        \App\Console\Commands\NewMovieVideosHLS::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

	    // $schedule->command('task:cron')->everyMinute();
	    $schedule->command('Cron:TestCron')->everyMinute();
	    $schedule->command('Video:NewMovieVideosHLS')->dailyAt('00:55');
	    $schedule->command('Video:UploadFolderToS3')->dailyAt('7:00');

	    $schedule->command('Video:NewEpisodeVideosHLS')->everyFourHours();
            $schedule->command('Video:UploadEpisodeFolderToS3')->everyFiveMinutes();


    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
