<?php
namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getEdit()
    {
        $member = \Auth::user()->member;
        $this->authorize('manage-member', $member);

        return view('app.profile.edit')->with(compact('member'));
    }

    public function postUpdate(Request $request)
    {
        $member = \Auth::user()->member;
        $this->authorize('manage-member', $member);

        $gender = (int)$request->get('gender', 0);
        if($gender == 0) {
            $gender = $member->getAttributes()['gender'];
        }
        $age = (int)$request->get('age', 0);
        if($age == 0) {
            $age = $member->getAttributes()['age'];
        }
        $address = (string)$request->get('hometown_address', '');
        $placeId = (string)$request->get('hometown_place_id', '');
        $lat = (float)$request->get('hometown_lat', 0);
        $lng = (float)$request->get('hometown_lng', 0);
        $member->update([
            'gender' => $gender,
            'age' => $age,
            'hometown_address' => $address,
            'hometown_place_id' => $placeId,
            'hometown_lat' => $lat,
            'hometown_lng' => $lng,
        ]);

        return redirect()->back();
    }
}