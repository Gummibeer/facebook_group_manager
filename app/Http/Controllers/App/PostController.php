<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    public function getIndex()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(50);

        return view('app.post.index')->with(compact('posts'));
    }

    public function getComments(Post $post)
    {
        $comments = $post->comments()
            ->withoutParent()
            ->orderBy('created_at', 'asc')
            ->with(['comments' => function($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->get();

        return view('app.post.widgets.comments')->with(compact('comments'));
    }
}
