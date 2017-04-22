<?php

namespace App\Console;

use App\Console\Commands\CommentLoad;
use App\Console\Commands\MemberGenderName;
use App\Console\Commands\MemberGenderPicture;
use App\Console\Commands\MemberLoad;
use App\Console\Commands\PostLoad;
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
        PostLoad::class,
        CommentLoad::class,
    ];

    protected function schedule(Schedule $schedule)
    {
         $schedule->command('load:members')
             ->hourly()
             ->runInBackground()
             ->withoutOverlapping();
         $schedule->command('load:posts', [
             '--since' => '-1 hour',
         ])
             ->everyTenMinutes()
             ->runInBackground()
             ->withoutOverlapping();
        $schedule->command('load:comments')
            ->everyThirtyMinutes()
            ->runInBackground()
            ->withoutOverlapping();
         $schedule->command('member:gender:name')
             ->hourly()
             ->runInBackground()
             ->withoutOverlapping();
         $schedule->command('token:refresh')->daily();
    }

    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
