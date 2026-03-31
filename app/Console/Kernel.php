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
        \App\Console\Commands\SendEmployeeOnboardingMail::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Temporary test schedule: every minute, log output.
        // Change back to dailyAt('09:00') after verification.
        $schedule->command('employees:send-onboarding-mail')
            ->everyMinute()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/onboarding-schedule.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
