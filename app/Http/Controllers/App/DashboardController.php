<?php

namespace App\Http\Controllers\App;

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

        return view('app.dashboard.index')->with([
            'membersByGender' => $membersByGender,
        ]);
    }
}
