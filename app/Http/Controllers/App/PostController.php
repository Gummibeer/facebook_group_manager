<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getIndex()
    {
        return view('app.post.index');
    }

    public function getApiComments(Post $post)
    {
        $comments = $post->comments()
            ->withoutParent()
            ->orderBy('created_at', 'asc')
            ->with(['comments' => function($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->get();

        return response()->json($comments);
    }

    public function getApiIndex(Request $request)
    {
        $cursor = $request->get('c');
        $date = base64_decode($cursor);
        if(empty($date)) {
            $date = Carbon::now('UTC')->__toString();
        }
        $limit = $request->get('l', 15);

        $posts = Post::query()
            ->with('comments')
            ->orderBy('created_at', 'desc')
            ->where('created_at', '<', $date)
            ->take($limit)
            ->get()
            ->map(function(Post $post) {
                $post->comments_count = $post->comments->count();
                return $post;
            });

        $data = [
            'limit' => $limit,
            'current' => [
                'cursor' => $cursor,
                'date' => $date,
                'url' => $request->fullUrl(),
            ],
            'posts' => $posts,
        ];
        if($posts->count() > 0) {
            $nextDate = $posts->last()->created_at;
            $nextCursor = base64_encode($nextDate);
            $data['next'] = [
                'cursor' => $nextCursor,
                'date' => $nextDate,
                'url' => route('api.post.index', [
                    'c' => $nextCursor,
                ]),
            ];
        }


        return response()->json($data);
    }
}
