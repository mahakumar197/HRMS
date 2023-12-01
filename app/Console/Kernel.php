<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         //  $schedule->command('sickleave:update')->monthly();
      //   $schedule->command('causalleave:first')->monthly();
      //   $schedule->command('ml:count')->monthly();
       //  $schedule->command('causalleave:second')->cron('0 0 1 7,10 *');
       //  $schedule->command('privilege:update')->yearly();
                             //->appendOutputTo('schduler.log');
                             
     $schedule->command('attendancenot:logged')->cron('0 15 * * *');
     $schedule->command('attendancenot:logged')->cron('20 18 * * *');
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
