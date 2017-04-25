<?php

namespace App\Console\Commands;

use App\Libs\AutoPost;
use App\Libs\AutoPostCollection;
use Illuminate\Console\Command;

class PublishAutopost extends Command
{
    protected $signature = 'publish:autopost';
    protected $description = 'Publishes all posts due at this moment.';

    public function handle()
    {
        $autoposts = array_filter(AutoPostCollection::all(), function(AutoPost $post) {
            return $post->isDue();
        });
        foreach($autoposts as $autopost) {
            if($postId = $autopost->publish()) {
                $this->info("published autopost with {$postId}");
            }
        }
    }
}
