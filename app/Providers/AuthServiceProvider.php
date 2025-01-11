<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });
        Gate::define('admin-lessor', function (User $user) {
            return $user->role === 'admin' || $user->role === 'lessor';
        });
        Gate::define('admin-employee', function (User $user) {
            return $user->role === 'admin' || $user->role === 'employee';
        });
        Gate::define('admin-lessor-employee', function (User $user) {
            return $user->role === 'admin' || $user->role === 'employee' || $user->role === 'lessor';
        });
        Gate::define('customer', function (User $user) {
            return $user->role === 'customer';
        });
        Gate::define('my_comment', function (User $user, Comment $comment) {
            return $user->id == $comment->user_id;
        });
    }
}
