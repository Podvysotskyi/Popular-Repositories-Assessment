<?php

namespace App\Providers;

use App\Services\GitHub\ApiService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ApiService::class, function (Application $app) {
            return new ApiService($app['config']['services']['github']);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }

    public function provides(): array
    {
        return [ApiService::class];
    }
}
