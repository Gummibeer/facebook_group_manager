<?php
namespace App\Libs;

use App\Models\User;
use Carbon\Carbon;
use Facebook\Authentication\AccessToken;
use Facebook\Facebook as FB;
use Illuminate\Database\Eloquent\Builder;

class Facebook
{
    public function getClient()
    {
        $fb = new FB([
            'app_id' => config('services.facebook.app_id'),
            'app_secret' => config('services.facebook.app_secret'),
            'default_graph_version' => 'v2.8',
        ]);
        $fb->setDefaultAccessToken($this->getAccessToken());
        return $fb;
    }

    public function getLongToken(AccessToken $token)
    {
        $fb = $this->getClient();
        $client = $fb->getOAuth2Client();
        return $client->getLongLivedAccessToken($token);
    }
    
    public function getAccessToken()
    {
        $users = User::whereHas('member', function (Builder $query) {
            return $query->byAdmin();
        })->get();
        if($users->count() == 0) {
            $users = User::byAdmin()->get();
        }
        if($users->count() > 0) {
            return $users->random()->facebook_token;
        }
        return '';
    }

    public function refreshLongToken(User $user)
    {
        $longToken = new AccessToken($user->facebook_token);
        $expires = new Carbon($longToken->getExpiresAt());
        if($expires->diffInDays() < 7) {
            $fb = $this->getClient();
            $client = $fb->getOAuth2Client();
            $code = $client->getCodeFromLongLivedAccessToken($longToken);
            $accessToken = $client->getAccessTokenFromCode($code);
            $user->update([
                'facebook_token' => $accessToken,
            ]);
        }
    }
}