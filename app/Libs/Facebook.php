<?php
namespace App\Libs;

use App\Models\User;
use Carbon\Carbon;
use Facebook\Authentication\AccessToken;
use Facebook\Facebook as FB;
use Illuminate\Database\Eloquent\Builder;

class Facebook
{
    public function getAppClient()
    {
        $fb = new FB([
            'app_id' => config('services.facebook.app_id'),
            'app_secret' => config('services.facebook.app_secret'),
            'default_graph_version' => 'v2.8',
        ]);
        $fb->setDefaultAccessToken(config('services.facebook.app_token'));
        return $fb;
    }

    public function getClient($newToken = false)
    {
        $fb = new FB([
            'app_id' => config('services.facebook.app_id'),
            'app_secret' => config('services.facebook.app_secret'),
            'default_graph_version' => 'v2.8',
        ]);
        $fb->setDefaultAccessToken($this->getAccessToken($newToken));
        return $fb;
    }

    public function getLongToken(AccessToken $token)
    {
        $fb = $this->getClient();
        $client = $fb->getOAuth2Client();
        return $client->getLongLivedAccessToken($token);
    }
    
    public function getAccessToken($newToken = false)
    {
        $users = User::whereHas('member', function (Builder $query) {
            return $query->byAdmin();
        })->get();
        if ($users->count() == 0) {
            $users = User::byAdmin()->get();
        }
        $users = $users->filter(function(User $user) {
            return in_array('user_managed_groups', $user->facebook_token_details['scopes']->asArray());
        });
        if ($users->count() > 0) {
            $user = $users->random();
            if ($newToken) {
                return $this->generateToken($user);
            }
            return $user->facebook_token;
        }
        return '';
    }

    public function refreshLongToken(User $user)
    {
        $longToken = new AccessToken($user->facebook_token);
        $expires = new Carbon($longToken->getExpiresAt());
        if($expires->diffInDays() < 7) {
            $user->update([
                'facebook_token' => $this->generateToken($user),
            ]);
        }
    }

    public function generateToken(User $user)
    {
        $fb = $this->getClient();
        $client = $fb->getOAuth2Client();
        $code = $client->getCodeFromLongLivedAccessToken(new AccessToken($user->facebook_token));
        return $client->getAccessTokenFromCode($code);
    }
    
    public function getAvatar($id)
    {
        return 'https://graph.facebook.com/'.$id.'/picture?type=square';
    }
}