<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Add schedule via route-driven setup for this app stack.
app(Schedule::class)->command('employees:send-onboarding-mail')
    ->everyMinute()
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/onboarding-schedule.log'));
