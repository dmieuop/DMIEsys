<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /** @var array */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot(): void
    {
        // $this->registerPolicies();
        $this->removePermissionFromDeactivatedUsers();
        $this->giveSuperAdminAllPermission();
    }

    public function giveSuperAdminAllPermission(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }

    public function removePermissionFromDeactivatedUsers(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->active_status ? null : false;
        });
    }
}
