<?php

namespace App\Providers;

use App\Services\QuestService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(QuestService::class, function ($app) {
            return new QuestService();
        });

        $this->app->alias(QuestService::class, 'questservice');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
