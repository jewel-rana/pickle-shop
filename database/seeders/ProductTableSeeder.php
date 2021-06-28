<?php

namespace Database\Seeders;

use App\Constants\AppConstant;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = Product::factory()->create();
        $variant = $product->productVariants()->create([
            'price' => 100,
            'status' => AppConstant::PRODUCT_AVAILABLE
        ]);

        $variant->attributes()->createMany([
            ['product_id' => $product->id, 'type' => 'weight', 'value' => '10kg'],
            ['product_id' => $product->id, 'type' => 'taste', 'value' => 'sweet']
        ]);
        $variant->stock()->create([
            'product_id' => $product->id,
            'qty' => 100
        ]);
    }
}
