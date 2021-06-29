<?php

namespace App\Jobs;

use App\Models\OrderDelivery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeliveryManAssignedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var OrderDelivery
     */
    private $orderDelivery;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(OrderDelivery $orderDelivery)
    {
        $this->orderDelivery = $orderDelivery;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //TODO Notify Delivery man (SMS / Email / FCM)
    }
}
