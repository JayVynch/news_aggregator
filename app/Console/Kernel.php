<?php

namespace App\Console;

use App\Jobs\GatherGuardianNewsJob;
use App\Jobs\GatherNews;
use App\Jobs\GatherNYTJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new GatherNews)->everySixHours();
        $schedule->job(new GatherNYTJob)->everySixHours();
        $schedule->job(new GatherGuardianNewsJob)->everySixHours();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
