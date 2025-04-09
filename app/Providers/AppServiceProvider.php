<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        Gate::define('access-admin', function (User  $user) {
            return $user->perfil === 'T'; // Administrador da TI
        });
    
        Gate::define('access-system-admin', function (User  $user) {
            return $user->perfil === 'S'; // Administrador do sistema
        });
    
        Gate::define('access-attendant', function (User  $user) {
            return $user->perfil === 'A'; // Atendente
        });
    }
}
