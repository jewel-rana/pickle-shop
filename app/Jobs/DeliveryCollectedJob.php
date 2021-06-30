<?php

namespace App\Jobs;

use App\Constants\AppConstant;
use App\Models\OrderDelivery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeliveryCollectedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $delivery_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($delivery_id)
    {
        $this->delivery_id = $delivery_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $delivery = OrderDelivery::with(['order.orderItems.productVariant.stock'])->findOrFail($this->delivery_id);
        //Update stock by deduction
        $delivery->order->orderItems->each(function($item, $key) {
            $item->productVariant['stock']->qty += $item->qty;
            $item->productVariant['stock']->save();
        });
        //TODO Sending notification to customer
    }
}
