<?php


namespace App\Services;


use App\Constants\AppConstant;

class ProductVariantService
{
    public function create(array $data, $product): bool
    {
        //save product variant
        $variant = $product->productVariants()->create([
            'price' => $data['price'],
            'status' => (array_key_exists('qty', $data)) ? AppConstant::PRODUCT_AVAILABLE : AppConstant::PRODUCT_UNAVAILABLE
        ]);

        //Save variant attributes
        if (is_array($data['attributes'])) {
            $maps = collect($data['attributes'])->map(function ($item, $key) use ($product) {
                return [
                    'product_id' => $product->id,
                    'type' => $item['type'],
                    'value' => $item['value']
                ];
            })->toArray();

            $variant->attributes()->createMany($maps);
        }

        //create stock
        $variant->stock()->create(['product_id' => $product->id, 'qty' => $data['qty'] ?? 0]);

        return (bool)$variant;
    }

    public function update($data, int $product_id): bool
    {
        return true;
    }
}
