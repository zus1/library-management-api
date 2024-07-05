<?php

namespace App\Providers;

use App\Listeners\AuthorListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Zus1\Serializer\Event\NormalizedDataEvent;

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
        Event::listen(
            NormalizedDataEvent::class,
            AuthorListener::class
        );
    }
}
