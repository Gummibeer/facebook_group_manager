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
            'default_access_token' => 'EAAT8r0XwZA74BANk6PTlTi7agEULUeEJZACjFNtWD59s3EnRsLAAbkq4Mdn5XXlPTFZATZBvZCKAqLxvi9FEZCcZAgxOzPELIOrrazDJh7A7ZB1KyRzRTNde8QmUYEVLWS5O7HvgrkfCOBt7lbfp0tV2UXdgulGRBZBIQDVMuvZASkqobbX9eqkVkS7h1RDD6b1CZCVdbHK3VCkDAZDZD',
        ]);
        return $fb;
    }
}
