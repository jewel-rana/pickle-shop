<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\MyTestCase;

class SimilarProductTest extends MyTestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_similar_product()
    {
        $response = parent::createProduct();
        $product = parent::getAProduct();

        $this->assertCount(1, $product->similarProducts);
    }
}
