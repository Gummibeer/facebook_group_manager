<?php

namespace App\Console\Commands;

use Facebook\Facebook;
use Illuminate\Console\Command;

abstract class FacebookCommand extends Command
{
    protected function getFacebook()
    {
        $fb = new Facebook([
            'app_id' => 1403729629702078,
            'app_secret' => '9b7dd860f16c3bf0c53e754ce968d192',
            'default_graph_version' => 'v2.8',
            'default_access_token' => 'EAAT8r0XwZA74BAKjkXNvsSZB4muZAgZCFpofeYjPtRvRAP2RrOcrQZBL4ZCJOFJQ8xUkZCZADsGSZCKzz7l8qiHuG5U1WmF8ZCcUcaek0zv0J1a1ik20l9Y7DbYh2PQixS5Dc6ffiuflwP3t0LwUTZCHGgWyYLuUre9ZCqOyYL6IQmRsWHwwqSXxLqwzi6oT2s3vgfZB3Yw5XcsnMfwZDZD',
        ]);
        $shortToken = $fb->getDefaultAccessToken();
        $this->comment('short expires_at:');
        var_dump($shortToken->getExpiresAt());
        $client = $fb->getOAuth2Client();
        $longToken = $client->getLongLivedAccessToken($shortToken);
        $this->comment('long expires_at:');
        var_dump($longToken->getExpiresAt());
        $code = $client->getCodeFromLongLivedAccessToken($longToken);
        $accessToken = $client->getAccessTokenFromCode($code);
        $this->comment('token expires_at:');
        var_dump($accessToken->getExpiresAt());
        $fb->setDefaultAccessToken($accessToken);
        return $fb;
    }
}
