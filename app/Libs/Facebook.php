<?php
namespace App\Libs;

use App\Models\User;
use Carbon\Carbon;
use Facebook\Authentication\AccessToken;
use Facebook\Exceptions\FacebookAuthenticationException;
use Facebook\Exceptions\FacebookResponseException;
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
        try {
            $fb->setDefaultAccessToken(config('services.facebook.app_token'));
        } catch(FacebookAuthenticationException $ex) {
            \Log::error($ex);
        }
        return $fb;
    }

    public function getClient($newToken = false, array $scopes = ['user_managed_groups'])
    {
        $fb = new FB([
            'app_id' => config('services.facebook.app_id'),
            'app_secret' => config('services.facebook.app_secret'),
            'default_graph_version' => 'v2.8',
        ]);
        try {
            $fb->setDefaultAccessToken($this->getAccessToken($newToken, $scopes));
        } catch(FacebookAuthenticationException $ex) {
            \Log::error($ex);
        }
        return $fb;
    }

    public function getLongToken(AccessToken $token)
    {
        $fb = $this->getClient();
        $client = $fb->getOAuth2Client();
        return $client->getLongLivedAccessToken($token);
    }
    
    public function getAccessToken($newToken = false, array $scopes = ['user_managed_groups'])
    {
        $users = User::whereHas('member', function (Builder $query) {
            return $query->byAdmin();
        })->get();
        if ($users->count() == 0) {
            $users = User::byAdmin()->get();
        }
        $users = $users->filter(function(User $user) use ($scopes) {
            return (
                !array_diff($scopes, $user->facebook_token_details['scopes']->asArray())
                &&
                $user->facebook_token_details['is_valid']
            );
        });
        if ($users->count() > 0) {
            $user = $users->random();
            if ($newToken) {
                return $this->generateToken($user);
            }
            return $user->facebook_token;
        }
        throw new FacebookAuthenticationException('There is no user with a valid access-token.');

    }

    public function refreshLongToken(User $user)
    {
        try {
            $longToken = new AccessToken($user->facebook_token);
            $expires = new Carbon($longToken->getExpiresAt());
            if ($expires->diffInDays() <= 14) {
                $user->update([
                    'facebook_token' => $this->generateToken($user),
                ]);
            }
        } catch(FacebookResponseException $ex) {
            \Log::critical($ex);
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