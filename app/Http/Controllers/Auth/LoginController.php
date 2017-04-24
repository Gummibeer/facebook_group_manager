<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Libs\Facebook;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $facebook;

    public function __construct(Facebook $facebook)
    {
        $this->facebook = $facebook;
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->middleware('auth', ['only' => 'getLogout']);
    }

    public function getLogin()
    {
        return view('auth.login');
    }

    public function getLogout()
    {
        \Auth::logout();
        return redirect()->route('auth.login');
    }

    public function getFacebookRedirect()
    {
        $fb = $this->facebook->getClient();
        $helper = $fb->getRedirectLoginHelper();
        $permissions = [
            'email',
            'public_profile',
            'user_managed_groups',
            'publish_actions',
        ];
        $url = $helper->getLoginUrl(route('auth.facebook.callback'), $permissions);
        return redirect()->to($url);
    }

    public function getFacebookCallback(Request $request)
    {
        $fb = $this->facebook->getClient();
        $helper = $fb->getRedirectLoginHelper();
        $helper->getPersistentDataHandler()->set('state', $request->get('state'));
        try {
            $accessToken = $helper->getAccessToken();
        } catch(\Exception $e) {
            return redirect()->route('auth.login');
        }

        if (! $accessToken->isLongLived()) {
            $accessToken = $this->facebook->getLongToken($accessToken);
        }

        $response = $fb->get('me?fields=id,name,email', $accessToken);
        $node = $response->getGraphNode();
        
        if(User::byEmail($node->getField('email'))->exists()) {
            $user = User::byEmail($node->getField('email'))->first();
        } elseif(User::byFacebookId($node->getField('id'))->exists()) {
            $user = User::byFacebookId($node->getField('id'))->first();
        } else {
            $user = User::create([
                'name' => $node->getField('name'),
                'email' => $node->getField('email'),
                'facebook_id' => $node->getField('id'),
                'facebook_token' => $accessToken,
            ]);
        }

        $user->update([
            'facebook_token' => $accessToken,
        ]);

        if(!$user->hasMember() && !$user->is_admin) {
            return redirect()->route('auth.login');
        }

        \Auth::login($user);
        return redirect()->route('app.dashboard.index');
    }
}
