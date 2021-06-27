<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductFeatureTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_product_create()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'json'
        ])
            ->json('POST', '/api/product', [
            'name' => 'First product',
            'description' => 'Description of the product',
                'variants' => ['hellow', 'test']
        ]);
        dd($response);
        $response->assertStatus(200);
    }
}
