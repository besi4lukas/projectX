<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        'App\Events\newRequest' => [
            'App\Listeners\RequestListener',
        ],

        'App\Events\playerTurn' => [
            'App\Listeners\TurnListener',
        ],

        'App\Events\newAcceptRequest' => [
            'App\Listeners\AcceptListener',
        ],

        'App\Events\newDeclineRequest' => [
            'App\Listeners\DeclineListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
