<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Libs\Gender;
use App\Models\Member;
use Illuminate\Http\Request;

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
                $actions = [
                    [
                        'title' => trans('labels.facebook.user_search'),
                        'icon' => 'fa-users',
                        'url' => 'https://facebook.com/groups/'.config('services.facebook.group_id').'/?member_query='.$member->full_name.'&view=members',
                    ], [
                        'title' => trans('labels.facebook.feed_search'),
                        'icon' => 'fa-comments',
                        'url' => 'https://facebook.com/groups/'.config('services.facebook.group_id').'/search/?query='.$member->full_name,
                    ], [
                        'title' => trans('labels.facebook.profile'),
                        'icon' => 'fa-facebook',
                        'url' => 'https://facebook.com/'.$member->id,
                    ], [
                        'title' => trans('labels.image_search'),
                        'icon' => 'fa-google',
                        'url' => 'http://www.google.com/searchbyimage?hl=en&image_url='.$member->picture,
                    ], [
                        'title' => trans('labels.edit'),
                        'icon' => 'fa-pencil',
                        'url' => route('app.member.edit', $member->id),
                        'target' => '_top',
                        'type' => 'warning',
                    ],
                ];

                $out = '<div class="btn-group pull-right">';
                foreach($actions as $action) {
                    $out .= '<a href="'.$action['url'].'" target="'.array_get($action, 'target', '_blank').'" class="btn btn-'.array_get($action, 'type', 'default').'-alt btn-xs" title="'.$action['title'].'"><i class="fa '.$action['icon'].'"></i></a>';
                }
                $out .= '</div>';
                return $out;
            })
            ->editColumn('gender', function(Member $member) {
                switch($member->gender) {
                    default:
                    case Gender::UNKNOWN:
                        return '<i class="fa '.$this->gender->getIcon(Gender::UNKNOWN).'"></i> '.trans('labels.'.$this->gender->getLabel(Gender::UNKNOWN));
                    case Gender::FEMALE:
                        return '<i class="fa '.$this->gender->getIcon(Gender::FEMALE).'"></i> '.trans('labels.'.$this->gender->getLabel(Gender::FEMALE));
                    case Gender::MALE:
                        return '<i class="fa '.$this->gender->getIcon(Gender::MALE).'"></i> '.trans('labels.'.$this->gender->getLabel(Gender::MALE));
                }
            })
            ->editColumn('is_silhouette', function(Member $member) {
                switch($member->is_silhouette) {
                    default:
                    case 0:
                        return '<i class="fa fa-times"></i> '.trans('labels.no');
                    case 1:
                        return '<i class="fa fa-check"></i> '.trans('labels.yes');
                }
            })
            ->editColumn('is_administrator', function(Member $member) {
                switch($member->is_administrator) {
                    default:
                    case 0:
                    return '<i class="fa fa-times"></i> '.trans('labels.no');
                    case 1:
                        return '<i class="fa fa-check"></i> '.trans('labels.yes');
                }
            })
            ->editColumn('is_approved', function(Member $member) {
                switch($member->is_approved) {
                    default:
                    case 0:
                    return '<i class="fa fa-times"></i> '.trans('labels.no');
                    case 1:
                        return '<i class="fa fa-check"></i> '.trans('labels.yes');
                }
            })
            ->rawColumns(['avatar','actions','gender','is_silhouette','is_administrator','is_approved'])
            ->make(true);
    }

    public function getEdit(Member $member)
    {
        return view('app.member.edit')->with(compact('member'));
    }

    public function postUpdate(Request $request, Member $member)
    {
        $gender = (int) $request->get('gender', 0);
        $age = (int) $request->get('age', 0);
        $approved = (int) $request->get('is_approved', 0);
        $member->update([
            'gender' => $gender,
            'age' => $age,
            'is_approved' => $approved,
        ]);

        return redirect()->back();
    }
}
