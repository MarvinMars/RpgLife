<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Characteristic;
use App\Models\Quest;
use App\Policies\CharacteristicPolicy;
use App\Policies\QuestPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
	    Quest::class => QuestPolicy::class,
	    Characteristic::class => CharacteristicPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
