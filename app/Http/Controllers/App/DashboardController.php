<?php

namespace App\Http\Controllers\App;

use App\Console\Commands\CommentLoad;
use App\Console\Commands\MemberLoad;
use App\Console\Commands\PostLoad;
use App\Http\Controllers\Controller;
use App\Libs\Gender;
use App\Models\Member;

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
}
