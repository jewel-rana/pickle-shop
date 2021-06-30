<?php

namespace Tests\Feature;

use App\Constants\AppConstant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\MyTestCase;

class OrderDeliveryFeatureTest extends MyTestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed');
    }

    public function test_order_delivered_to_customer()
    {
        parent::placeOrder();
        $order = parent::getOrder();
        $this->assertNotEmpty($order);
        if($order) {
            $response = $this->withHeaders(parent::getHeader())
                ->json('POST', 'api/order/delivery', [
                    'order_id' => $order->id,
                    'delivery_man_name' => $this->faker()->name(),
                    'delivery_man_mobile' => '01911785317'
                ]);

            $response->assertJson(function(AssertableJson $json) {
                $json->where('status', true)
                    ->etc();
            });
        }
    }

    public function test_order_delivery_failed_and_update_stock()
    {
        parent::assignDeliveryMan();
        $delivery = parent::getDelivery();
        $this->assertNotEmpty($delivery);
        if($delivery) {
            $response = $this->withHeaders(parent::getHeader())
                ->json('PUT', 'api/order/delivery/' . $delivery->id, [
                    'status' => AppConstant::DELIVERY_COLLECTED
                ]);

            $response->assertJson(function(AssertableJson $json) {
                $json->where('status', true)
                    ->etc();
            });

            $delivery = parent::getDelivery();
            $this->assertEquals(AppConstant::DELIVERY_COLLECTED, $delivery->status);
        }
    }
}
