<?php

namespace App\Console\Commands;

use App\Console\Traits\HasRunningState;
use App\Libs\Facebook;
use App\Models\Post;
use App\Models\Comment;
use App\Console\Command;

class CommentLoad extends Command
{
    use HasRunningState;

    protected $signature = 'load:comments';
    protected $description = 'Loads all posts from facebook.';

    protected $facebook;
    protected $client;

    public function __construct(Facebook $facebook)
    {
        $this->facebook = $facebook;
        parent::__construct();
    }

    public function handle()
    {
        $this->client = $this->facebook->getClient(true);
        $groupId = config('services.facebook.group_id');
        $posts = Post::byCreatedAt('-3 days')->orderBy('created_at', 'desc')->get();
        $this->info('load comments for group #' . $groupId . ' for ' . $posts->count() . ' latest posts');
        foreach ($posts as $post) {
            $this->scrapeData($post->id);
        }
    }

    protected function scrapeData($postId, $parentId = null)
    {
        $id = is_null($parentId) ? $postId : $parentId;
        try {
            $fb = $this->client;
            $response = $fb->get($id . '/comments?fields=id,message,from,created_time,attachment,comment_count&limit=1000');
            $edge = $response->getGraphEdge();
            $comments = collect([]);
            do {
                $this->comment('save graph edge data');
                $comments = $comments->merge($edge->asArray());
                foreach ($edge->asArray() as $fbComment) {
                    $this->handleComment($postId, $fbComment, $parentId);
                }
                $edge = $fb->next($edge);
            } while (!is_null($edge));
            $this->info('scraped ' . $comments->count() . ' comments data for ' . implode(':', array_filter([$postId, $parentId])));
        } catch (\Exception $ex) {
            $this->error($ex);
        }
    }

    protected function handleComment($postId, array $fbComment, $parentId = null)
    {
        if(!empty($fbComment['message'])) {
            try {
                $data = [
                    'id' => $fbComment['id'],
                    'message' => $fbComment['message'],
                    'created_at' => $fbComment['created_time'],
                    'from_id' => $fbComment['from']['id'],
                    'from_name' => $fbComment['from']['name'],
                    'post_id' => $postId,
                    'parent_id' => $parentId,
                    'picture' => array_get($fbComment, 'attachment.media.image.src'),
                ];
                if (!Comment::byId($fbComment['id'])->exists()) {
                    Comment::create($data);
                } else {
                    Comment::byId($fbComment['id'])->first()->update($data);
                }
                if ($fbComment['comment_count'] > 0) {
                    $this->comment('load sub-comments for ' . $fbComment['id']);
                    $this->scrapeData($postId, $fbComment['id']);
                }
            } catch (\Exception $ex) {
                $this->error($ex);
                $this->comment(json_encode($fbComment, JSON_PRETTY_PRINT));
            }
        }
    }
}
