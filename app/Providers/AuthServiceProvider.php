<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models\Users;

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

        //

        $data = Users::keypermission();

        foreach ($data as $list) {
            foreach ($list['data'] as $list2) {
                Gate::define( $list2['value'] , function($user) use ($list2) {
                    return $user->hasAccess( $list2['value'] );
                });
            }
        }
    }
}
