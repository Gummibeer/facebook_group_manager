<?php

namespace App\Providers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        \Gate::before(function(User $user) {
            if($user->is_admin) {
                return true;
            }
        });

        \Gate::define('member', function (User $user) {
            return $user->hasMember();
        });

        \Gate::define('administration', function (User $user) {
            return false;
        });

        \Gate::define('manage-member', function (User $user, Member $member = null) {
            if(is_null($member)) {
                return false;
            }
            return $user->facebook_id == $member->id;
        });

        \Gate::define('manage-user', function (User $user) {
            return false;
        });

        \Gate::define('view-post', function (User $user) {
            return $user->hasMember();
        });

        \Gate::define('view-autopost', function (User $user) {
            return false;
        });
    }
}
