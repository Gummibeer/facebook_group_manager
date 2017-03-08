<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Libs\Gender;
use App\Models\Member;

class MemberController extends Controller
{
    protected $gender;

    public function __construct(Gender $gender)
    {
        $this->gender = $gender;
    }

    public function getIndex()
    {
        return view('app.member.index');
    }

    public function getDatatable()
    {
        return \Datatables::of(Member::byActive()->get())
            ->addColumn('avatar', function(Member $member) {
                return '<img src="'.$member->avatar.'" class="img-responsive">';
            })
            ->addColumn('actions', function(Member $member) {
                return '<div class="btn-group">'.
                    '<a href="https://facebook.com/groups/1561917967449058/?member_query='.$member->full_name.'&view=members" target="_blank" class="btn btn-default-alt btn-xs"><i class="fa fa-search"></i></a>'.
                    '<a href="https://facebook.com/groups/1561917967449058/search/?query='.$member->full_name.'" target="_blank" class="btn btn-default-alt btn-xs"><i class="fa fa-list"></i></a>'.
                    '<a href="https://facebook.com/'.$member->id.'" target="_blank" class="btn btn-default-alt btn-xs"><i class="fa fa-user"></i></a>'.
                    '</div>';
            })
            ->editColumn('gender', function(Member $member) {
                switch($member->gender) {
                    default:
                    case Gender::UNKNOWN:
                        return '<i class="fa '.$this->gender->getIcon(Gender::UNKNOWN).'"></i>';
                    case Gender::FEMALE:
                        return '<i class="fa '.$this->gender->getIcon(Gender::FEMALE).'"></i>';
                    case Gender::MALE:
                        return '<i class="fa '.$this->gender->getIcon(Gender::MALE).'"></i>';
                }
            })
            ->editColumn('is_silhouette', function(Member $member) {
                switch($member->is_silhouette) {
                    default:
                    case 0:
                        return '<i class="fa fa-check"></i> ja';
                    case 1:
                        return '<i class="fa fa-times"></i> nein';
                }
            })
            ->editColumn('is_administrator', function(Member $member) {
                switch($member->is_administrator) {
                    default:
                    case 0:
                        return '<i class="fa fa-times"></i> nein';
                    case 1:
                        return '<i class="fa fa-check"></i> ja';
                }
            })
            ->rawColumns(['avatar','actions','gender','is_silhouette','is_administrator'])
            ->make(true);
    }
}
