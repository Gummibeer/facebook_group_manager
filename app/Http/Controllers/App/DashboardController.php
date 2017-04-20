<?php

namespace App\Http\Controllers\App;

use App\Console\Commands\CommentLoad;
use App\Console\Commands\MemberLoad;
use App\Console\Commands\PostLoad;
use App\Http\Controllers\Controller;
use App\Libs\Gender;
use App\Models\Comment;
use App\Models\Member;
use App\Models\Post;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getIndex()
    {
        $gender = app(Gender::class);

        $members = Member::byActive()->get();
        $membersByGender = [];
        foreach($gender->getLabels() as $key => $name) {
            $membersByGender[trans('labels.'.$name)] = $members->where('gender', $key)->count();
        }
        $membersByApproved = [];
        $membersByApproved[trans('labels.approved.0')] = $members->where('is_approved', 0)->count();
        $membersByApproved[trans('labels.approved.1')] = $members->where('is_approved', 1)->count();

        $commands = [
            app(MemberLoad::class),
            app(PostLoad::class),
            app(CommentLoad::class),
        ];

        return view('app.dashboard.index')->with([
            'membersByGender' => $membersByGender,
            'membersByApproved' => $membersByApproved,
            'commands' => $commands,
        ]);
    }

    public function getActivity($day)
    {
        $day = Carbon::parse($day, 'UTC');

        $startDay = $day->startOfDay()->__toString();
        $endDay = $day->endOfDay()->__toString();
        $startMonth = $day->startOfMonth()->__toString();
        $endMonth = $day->endOfMonth()->__toString();

        $postsMonth = Post::query()
            ->where('created_at', '>=', $startMonth)
            ->where('created_at', '<=', $endMonth)
            ->count();

        $commentsMonth = Comment::query()
            ->where('created_at', '>=', $startMonth)
            ->where('created_at', '<=', $endMonth)
            ->count();

        $postsDay = Post::query()
            ->where('created_at', '>=', $startDay)
            ->where('created_at', '<=', $endDay)
            ->count();

        $commentsDay = Comment::query()
            ->where('created_at', '>=', $startDay)
            ->where('created_at', '<=', $endDay)
            ->count();

        $monthDays = $day->daysInMonth;
        $sinceDays = $day->startOfMonth()->diffInDays(Carbon::now('UTC'), true);
        $days = min($monthDays, $sinceDays);

        $postsAvg = $postsMonth / $days;
        $commentsAvg = $commentsMonth / $days;

        return response()->json(compact('postsDay', 'commentsDay', 'postsMonth', 'commentsMonth', 'days', 'postsAvg', 'commentsAvg'));
    }
}
