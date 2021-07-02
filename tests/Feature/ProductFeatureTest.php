<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\MyTestCase;

class ProductFeatureTest extends MyTestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_product_store_and_update_method()
    {
        $response = parent::createProduct();
        $response->assertJson(function (AssertableJson $json) {
            $json->where('status', true)->etc();
        });
        $product = parent::getAProduct();
        $this->assertNotEmpty($product);
        $this->assertCount(1, $product->productVariants);
        $this->assertCount(2, $product->productVariants->first()->attributes);
        $this->assertNotEmpty($product->productVariants->first()->stock);

        $this->withHeaders(parent::getHeader())
            ->json('PUT', '/api/product/' . $product->id, [
            'name' => 'Updated',
            'description' => 'Updated description'
        ]);

        $product = Product::find($product->id);
        $this->assertContains('Updated', $product->toArray());
    }
}
