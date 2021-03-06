<?php

namespace Tests\Feature;

use App\Models\Offer;
use App\Models\Product;
use App\Repositories\OfferRepository;
use App\Services\CartService;
use App\Services\OfferService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\MyTestCase;

class OrderFeatureTest extends MyTestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_order_feature()
    {
        $product = Product::all()->first();
        $this->withHeaders(parent::getHeader())
            ->json('POST', '/api/cart/', [
                'product_id' => $product->id,
                'product_sku' => $product->productVariants->first()->sku,
                'qty' => 1
            ]);
        $response = $this->withHeaders(parent::getHeader())
            ->json('POST', '/api/order', [
                'customer_name' => $this->faker()->name(),
                'customer_email' => $this->faker()->email(),
                'customer_address' => $this->faker()->address
            ]);
        $response
            ->assertJson(function (AssertableJson $json) {
                $json->where('status', true)
                    ->whereType('status', 'boolean')
                    ->where('message', 'You have successfully placed an order')
                    ->etc();
            });
        $cartService = new CartService(new OfferService(new OfferRepository(new Offer())));
        $this->assertCount(0, $cartService->getCartItems());
    }
}
