<?php

namespace App\Console\Commands;

use App\Libs\Facebook;
use App\Models\User;
use App\Console\Command;

class TokenRefresh extends Command
{
    protected $signature = 'token:refresh';
    protected $description = 'Refreshs the long live access tokens.';

    protected $facebook;

    public function __construct(Facebook $facebook)
    {
        $this->facebook = $facebook;
        parent::__construct();
    }

    public function handle()
    {
        $users = User::get();
        $this->info('refresh the access tokens for '.$users->count().' users');
        $bar = $this->output->createProgressBar($users->count());
        foreach($users as $user) {
            $this->facebook->refreshLongToken($user);
            $bar->advance();
        }
        $bar->finish();
        $this->line('');
    }
}
