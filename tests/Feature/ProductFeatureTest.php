<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProductFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_product_store_and_update_method()
    {
        $this->withHeaders($this->getHeader())
            ->json('POST', '/api/product', [
                'name' => 'First product',
                'description' => 'Description of the product',
                'variants' => [
                    [
                        'sku' => Str::uuid(),
                        'price' => 100,
                        'qty' => 100,
                        'attributes' => [
                            ['type' => 'size', 'value' => 'small'],
                            ['type' => 'color', 'value' => 'blue']
                        ]
                    ]
                ]
            ]);
        $product = Product::with(['productVariants.attributes', 'productVariants.stock'])->find(1);
        $this->assertCount(1, $product->productVariants);
        $this->assertCount(2, $product->productVariants->first()->attributes);
        $this->assertNotEmpty($product->productVariants->first()->stock);

        $this->withHeaders($this->getHeader())
            ->json('PUT', '/api/product/' . $product->id, [
            'name' => 'Updated',
            'description' => 'Updated description'
        ]);

        $product = Product::find($product->id);
        $this->assertContains('Updated', $product->toArray());
    }

    private function getHeader(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'json'
        ];
    }
}
