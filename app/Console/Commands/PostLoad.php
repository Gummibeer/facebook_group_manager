<?php

namespace App\Console\Commands;

use App\Console\Command;
use App\Console\Traits\HasRunningState;
use App\Libs\Facebook;
use App\Models\Post;
use Carbon\Carbon;

class PostLoad extends Command
{
    use HasRunningState;

    protected $signature = 'load:posts {--since=-1 day}';
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

        try {
            $since = Carbon::now('UTC')->modify($this->option('since'));
        } catch(\Exception $ex) {
            $this->error('The since option is unparsable - fallback "-1 day" is used');
            $since = Carbon::now('UTC')->subDay();
        }

        $this->info('load posts for group #'.$groupId.' since '.$since->format('Y-m-d H:i:s T'));
        $response = $fb->get($groupId.'/feed?fields=message,created_time,id,from,full_picture&limit=1000&since='.$since->getTimestamp());
        $edge = $response->getGraphEdge();
        $posts = collect([]);
        $created = 0;
        do {
            $this->comment('save graph edge data');
            $posts = $posts->merge($edge->asArray());
            $bar = $this->output->createProgressBar($edge->count());
            foreach($edge->asArray() as $fbPost) {
                if(array_key_exists('message', $fbPost) && array_key_exists('from', $fbPost)) {
                    $exists = Post::byId($fbPost['id'])->exists();
                    if (!$exists) {
                        try {
                            $post = Post::create([
                                'id' => $fbPost['id'],
                                'message' => $fbPost['message'],
                                'created_at' => $fbPost['created_time'],
                                'from_id' => $fbPost['from']['id'],
                                'from_name' => $fbPost['from']['name'],
                                'picture' => array_get($fbPost, 'full_picture'),
                            ]);
                            if($post instanceof Post) {
                                $created++;
                            }
                        } catch(\Exception $ex) {
                            $this->error($ex->getMessage());
                            $this->comment(json_encode($fbPost, JSON_PRETTY_PRINT));
                        }
                    }
                }
                $bar->advance();
            }
            $bar->finish();
            $this->line('');
            $edge = $fb->next($edge);
        } while(!is_null($edge));
        $this->info('scraped '.$posts->count().' posts data');
        $this->info('created '.$created.' posts');
    }
}
