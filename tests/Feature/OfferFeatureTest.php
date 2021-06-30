<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\MyTestCase;
use Tests\TestCase;

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
}
