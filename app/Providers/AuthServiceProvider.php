<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use App\Policies\BookPolicy;
use App\Policies\ReviewPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Book::class => BookPolicy::class,
        Review::class => ReviewPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('set-admin', function (User $user){
            return $user->is_admin;
        });
    }
}
