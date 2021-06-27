<?php


namespace App\Services;


use App\Constants\AppConstant;
use App\Models\Product;

class ProductVariantService
{
    public function create(array $data, $product): bool
    {
        //save product variant
        $variant = $product->productVariants()->create([
            'price' => $data['price'],
            'status' => $data['qty'] ?? AppConstant::PRODUCT_AVAILABLE
        ]);

        //Save variant attributes
        if(is_array($data['attributes'])) {
            $variant->attributes()->createMany([
                collect($data['attributes'])->map(function($item, $key) {
                    return [
                       'type' => $item['type'],
                        'value' => $item['value']
                    ];
                })->toArray()
            ]);
        }

        //create stock
        $variant->stock()->create(['qty' => $data['qty'] ?? 0]);

        return (bool) $variant;
    }

    public function update($data, int $product_id): bool
    {
        return true;
    }
}
