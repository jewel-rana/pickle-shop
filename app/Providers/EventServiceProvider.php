<?php

namespace App\Providers;

use App\Events\DeliveryManAssignedEvent;
use App\Events\OrderDeliveryUpdateEvent;
use App\Events\OrderPlacedEvent;
use App\Listeners\DeliveryManAssignedEventListener;
use App\Listeners\OrderDeliveryUpdateEventListener;
use App\Listeners\OrderPlacedEventListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        OrderPlacedEvent::class => [
            OrderPlacedEventListener::class
        ],
        OrderDeliveryUpdateEvent::class => [
            OrderDeliveryUpdateEventListener::class
        ],
        DeliveryManAssignedEvent::class => [
            DeliveryManAssignedEventListener::class
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
