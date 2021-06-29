<?php

namespace App\Listeners;

use App\Constants\AppConstant;
use App\Events\OrderDeliveryUpdateEvent;
use App\Jobs\DeliveryCollectedJob;
use App\Jobs\DeliveryCompleteJob;
use App\Jobs\DeliveryFailedJob;
use App\Jobs\DeliveryProcessingJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderDeliveryUpdateEventListener
{
    public function handle(OrderDeliveryUpdateEvent $event)
    {
        switch ($event->data['status']) {
            case AppConstant::DELIVERY_PROCESSING :
                dispatch(new DeliveryProcessingJob($event->data['delivery_id']));
                break;
            case AppConstant::DELIVERY_COLLECTED :
                dispatch(new DeliveryCollectedJob($event->data['delivery_id']));
                break;
            case AppConstant::DELIVERY_COMPLETE :
                dispatch(new DeliveryCompleteJob($event->data['delivery_id']));
                break;
            case AppConstant::DELIVERY_FAILED :
                dispatch(new DeliveryFailedJob($event->data['delivery_id']));
                break;
        }
    }
}
