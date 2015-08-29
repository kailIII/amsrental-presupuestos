<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $prefix = Carbon::now()->format('Y/m/d');
        $schedule->command('backup:run --only-db --prefix="db/'.$prefix.'"')->hourly();
        $schedule->command('backup:run --prefix="files/'.$prefix.'"')->weekly();
        $schedule->command('backup:clean')->daily();
    }

}
