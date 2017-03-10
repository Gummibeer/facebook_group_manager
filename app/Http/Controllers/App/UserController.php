<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getIndex()
    {
        return view('app.user.index');
    }

    public function getDatatable()
    {
        return \Datatables::of(User::get())
            ->addColumn('actions', function(User $user) {
                $actions = [
                    [
                        'title' => trans('labels.edit'),
                        'icon' => 'fa-pencil',
                        'url' => route('app.user.edit', $user->getKey()),
                        'type' => 'warning',
                        'target' => '_top',
                    ],
                ];

                $out = '<div class="btn-group pull-right">';
                foreach($actions as $action) {
                    $out .= '<a href="'.$action['url'].'" target="'.array_get($action, 'target', '_blank').'" class="btn btn-'.array_get($action, 'type', 'default').'-alt btn-xs" title="'.$action['title'].'"><i class="fa '.$action['icon'].'"></i></a>';
                }
                $out .= '</div>';
                return $out;
            })
            ->editColumn('is_admin', function(User $user) {
                switch($user->is_admin) {
                    default:
                    case 0:
                    return '<i class="fa fa-times"></i> '.trans('labels.no');
                    case 1:
                        return '<i class="fa fa-check"></i> '.trans('labels.yes');
                }
            })
            ->rawColumns(['actions','is_admin'])
            ->make(true);
    }

    public function getEdit(User $user)
    {
        return view('app.user.edit')->with(compact('user'));
    }

    public function postUpdate(Request $request, User $user)
    {
        $admin = (int) $request->get('is_admin', 0);
        $user->update([
            'is_admin' => $admin,
        ]);

        return redirect()->back();
    }
}
