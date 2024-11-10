<?php

namespace App\Providers;

use App\Services\GitHubService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(GitHubService::class, function (Application $app) {
            return new GitHubService($app['config']['services']['github']);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    public function provides(): array
    {
        return [GitHubService::class];
    }
}
