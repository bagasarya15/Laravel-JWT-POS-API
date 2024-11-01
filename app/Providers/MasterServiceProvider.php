<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MasterServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            'App\Interfaces\Master\UserInterface',
            'App\Repositories\Master\UserRepository'
        );

        $this->app->bind(
            'App\Interfaces\Master\EmployeeInterface',
            'App\Repositories\Master\EmployeeRepository'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
