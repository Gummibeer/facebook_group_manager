<?php

namespace App\Console\Commands;

use App\Console\Traits\HasRunningState;
use App\Libs\Facebook;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Console\Command;

class CommentLoad extends Command
{
    use HasRunningState;

    protected $signature = 'load:comments';
    protected $description = 'Loads all posts from facebook.';

    protected $facebook;

    public function __construct(Facebook $facebook)
    {
        $this->facebook = $facebook;
        parent::__construct();
    }

    public function handle()
    {
        $fb = $this->facebook->getClient(true);
        $groupId = config('services.facebook.group_id');

        $posts = Post::byCreatedAt('-3 days')->get();
        $this->info('load comments for group #' . $groupId.' for '.$posts->count().' latest posts');
        foreach ($posts as $post) {
            try {
                $response = $fb->get($post->id . '/comments?fields=id,message,from,created_time,attachment&limit=1000');
                $edge = $response->getGraphEdge();
                $comments = collect([]);
                do {
                    $this->comment('save graph edge data');
                    $comments = $comments->merge($edge->asArray());
                    $bar = $this->output->createProgressBar($edge->count());
                    foreach ($edge->asArray() as $fbComment) {
                        $exists = Comment::byId($fbComment['id'])->exists();
                        if (!$exists) {
                            try {
                                Comment::create([
                                    'id' => $fbComment['id'],
                                    'message' => $fbComment['message'],
                                    'created_at' => $fbComment['created_time'],
                                    'from_id' => $fbComment['from']['id'],
                                    'from_name' => $fbComment['from']['name'],
                                    'post_id' => $post->id,
                                ]);
                            } catch (\Exception $ex) {
                                $this->error($ex->getMessage());
                                $this->comment(json_encode($fbComment, JSON_PRETTY_PRINT));
                            }
                        }
                        $bar->advance();
                    }
                    $bar->finish();
                    $this->line('');
                    $edge = $fb->next($edge);
                } while (!is_null($edge));
                $this->info('scraped ' . $comments->count() . ' comments data');
            } catch (\Exception $ex) {
                $this->error($ex->getMessage());
            }
        }
    }
}
