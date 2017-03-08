<?php

namespace App\Console;

use App\Console\Commands\MemberGender;
use App\Console\Commands\MemberLoad;
use App\Console\Commands\TokenRefresh;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        MemberGender::class,
        MemberLoad::class,
        TokenRefresh::class,
    ];

    protected function schedule(Schedule $schedule)
    {
         $schedule->command('member:load')->hourly();
         $schedule->command('member:gender')->hourly();
         $schedule->command('token:refresh')->daily();
    }

    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
