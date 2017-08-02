<?php

namespace App\Console;

use App\Console\Commands\AsRoot;
use App\Console\Commands\DeployProject;
use App\Console\Commands\RollbackProject;
use App\Console\Commands\Test;
use App\Console\Commands\UpdateEnv;
use App\Console\Commands\WatchEs;
use App\Console\Commands\ZeusGitPull;
use App\Console\Commands\ZeusLoadEnvFile;
use App\Console\Commands\ZeusMigrate;
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
        ZeusLoadEnvFile::class,
        DeployProject::class,
        RollbackProject::class,
        ZeusMigrate::class,
        ZeusGitPull::class,
        UpdateEnv::class,
        Test::class,
        AsRoot::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('watch:diskSpace')->hourly()->withoutOverlapping();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
