<?php

namespace App\Listeners;

use App\Events\DeliveryManAssignedEvent;
use App\Jobs\DeliveryManAssignedJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeliveryManAssignedEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle(DeliveryManAssignedEvent $event)
    {
        dispatch(new DeliveryManAssignedJob($event->orderDelivery));
    }
}
