<?php

namespace App\Listeners;

use App\Events\OrderPlacedEvent;
use App\Jobs\OrderInvoiceSendJob;
use App\Jobs\OrderStockAdjustmentJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderPlacedEventListener
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

    /**
     * Handle the event.
     *
     * @param OrderPlacedEvent $event
     * @return void
     */
    public function handle(OrderPlacedEvent $event)
    {
        dispatch(new OrderInvoiceSendJob($event->order));
        dispatch(new OrderStockAdjustmentJob($event->order));
    }
}
