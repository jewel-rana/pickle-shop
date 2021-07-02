<?php

namespace Tests\Feature;

use App\Models\Offer;
use App\Repositories\OfferRepository;
use App\Services\CartService;
use App\Services\OfferService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\MyTestCase;

class OfferFeatureTest extends MyTestCase
{
    use RefreshDatabase;
    public function test_offer_store_method()
    {
        $response = $this->withHeaders(parent::getHeader())
            ->json('POST', 'api/offer', [
                'type' => 'discount',
                'min_order' => 2,
                'discount_type' => 'percent',
                'amount' => 10,
                'offer_start' => date('Y-m-d H:i:s'),
                'offer_end' => now()->addDays(30)->format('Y-m-d H:i:s'),
                'product_ids' => [1]
            ]);

        $response->assertJson(function(AssertableJson $assertableJson) {
            $assertableJson->where('status', true)->etc();
        });

        $this->assertDatabaseCount('offer_product', 1);
    }

    public function test_offer_update_method()
    {
        parent::createOffer('discount');
        $offer = parent::getOffer();
        $this->assertNotNull($offer);
        if($offer) {
            $response = $this->withHeaders(parent::getHeader())
                ->json('PUT', 'api/offer/' . $offer->id, [
                    'type' => 'discount',
                    'min_order' => 2,
                    'discount_type' => 'percent',
                    'amount' => 10,
                    'offer_start' => date('Y-m-d H:i:s'),
                    'offer_end' => now()->addDays(30)->format('Y-m-d H:i:s'),
                    'product_ids' => [1, 2]
                ]);

            $response->assertJson(function (AssertableJson $assertableJson) {
                $assertableJson->where('status', true)->etc();
            });

            $this->assertDatabaseCount('offer_product', 2);
        }
    }

    public function test_offer_cart_discount()
    {
        parent::createOffer('discount');
        $offer = parent::getOffer();
        $this->assertNotNull($offer);
        parent::addToCart();
        $cartService = new CartService(new OfferService(new OfferRepository(new Offer())));
        $this->assertEquals(20.0, $cartService->getCartItems()->first()['discount']);
    }

    public function test_offer_order_discount()
    {
        parent::createOffer();
        parent::placeOrder();
        $order = parent::getOrder();
        $this->assertEquals(20.0, $order->discount);
    }
}
