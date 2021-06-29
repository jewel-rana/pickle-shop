<?php

namespace App\Events;

use App\Models\OrderDelivery;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeliveryManAssignedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderDelivery;

    public function __construct(OrderDelivery $orderDelivery)
    {
        $this->orderDelivery = $orderDelivery;
    }
}
