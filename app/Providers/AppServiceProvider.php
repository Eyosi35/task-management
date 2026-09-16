<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use App\Models\User;



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
        Gate::define('admin-task', function($user){
            return $user->isAdmin();
        });
        
        RateLimiter::for('login', function(Request $request){
            return Limit::perMinute(5)
                ->by($request->ip());
        });

        RateLimiter::for('task_requests', function(Request $request){
            return Limit::perMinute(60)
                ->by($request->user()->id);
        });
    }
}
