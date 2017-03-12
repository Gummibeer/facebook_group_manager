<?php

namespace App\Console;

use App\Console\Commands\MemberGenderName;
use App\Console\Commands\MemberGenderPicture;
use App\Console\Commands\MemberLoad;
use App\Console\Commands\TokenRefresh;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        MemberGenderName::class,
        MemberGenderPicture::class,
        MemberLoad::class,
        TokenRefresh::class,
    ];

    protected function schedule(Schedule $schedule)
    {
         $schedule->command('member:load')->hourly()->withoutOverlapping();
         $schedule->command('member:gender:name')->hourly()->withoutOverlapping();
         $schedule->command('token:refresh')->daily();
    }

    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
