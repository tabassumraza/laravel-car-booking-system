<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    // to protect admin policy 
    protected $policies = [
    User::class => AdminPolicy::class,
];
    /**
     * Register any authentication / authorization services.
     */
   
    // Check Gate definitions
public function boot()
{
    $this->registerPolicies();

    Gate::define('AdminMiddleware', function ($user) {
        return $user->isAdmin(); // or your admin check logic
    });
}
}
