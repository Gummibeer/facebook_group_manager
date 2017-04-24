<?php

namespace App\Console\Commands;

use App\Libs\Python;
use App\Models\Post;
use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PostSentiment extends Command
{
    protected $signature = 'post:sentiment';
    protected $description = 'Loads the sentiment for every post.';

    protected $python;

    public function __construct(Python $python)
    {
        $this->python = $python;
        parent::__construct();
    }

    public function handle()
    {
        $this->info('load sentiments for posts');
        $posts = Post::withoutSentiment()->get();
        $bar = $this->output->createProgressBar($posts->count());
        foreach($posts as $post) {
            $message = $post->message;
            try {
                $sentiment = $this->python->call('get_sentiment', $message) * 1;
                $post->update([
                    'sentiment' => $sentiment,
                ]);
            } catch(ProcessFailedException $ex) {
                $this->error("post-id: ".$post->id." - ".$ex->getMessage());
            }
            $bar->advance();
        }
        $bar->finish();
    }
}
