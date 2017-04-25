<?php

namespace App\Http\Controllers\App;

use App\Console\Commands\CommentLoad;
use App\Console\Commands\MemberLoad;
use App\Console\Commands\PostLoad;
use App\Http\Controllers\Controller;
use App\Libs\AutoPostCollection;
use App\Libs\Gender;
use App\Models\Comment;
use App\Models\Member;
use App\Models\Post;
use Carbon\Carbon;

class AutopostController extends Controller
{
    public function getIndex()
    {
        $autoposts = AutoPostCollection::all();

        return view('app.autopost.index')->with(compact('autoposts'));
    }
}
