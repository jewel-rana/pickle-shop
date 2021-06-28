<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CartFeatureTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_cart_feature()
    {
        $cartService = new CartService();
        $product = Product::all()->first();
        $this->withHeaders($this->getHeader())
            ->json('POST', '/api/cart/', [
                'product_id' => $product->id,
                'product_sku' => $product->productVariants->first()->sku,
                'qty' => 1
            ]);
        $this->assertCount(1, $cartService->getCartItems());
        $this->withHeaders($this->getHeader())
            ->json('DELETE', '/api/cart/remove/' . $product->productVariants->first()->sku, []);
        $this->assertCount(0, $cartService->getCartItems());
    }

    private function getHeader(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'json'
        ];
    }
}
