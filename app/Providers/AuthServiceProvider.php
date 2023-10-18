<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\User;
// use Illuminate\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
// use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define("mahasiswa", function (User $user) {
            return $user->level === "mahasiswa";
        });

        Gate::define("dosenwali", function (User $user) {
            return $user->level === "dosenwali";
        });

        Gate::define("operator", function (User $user) {
            return $user->level === "operator";
        });

        Gate::define("departemen", function (User $user) {
            return $user->level === "departemen";
        });
    }
}
