<?php


namespace App\Services;


use App\Constants\AppConstant;
use App\Models\Product;
use phpDocumentor\Reflection\Types\Float_;

class CartService
{
    public function add(array $data)
    {
        $carts = session()->get('carts') ?? [];
        if(array_key_exists($data['product_sku'], $carts)) {
            $carts[$data['product_sku']]['qty'] += $data['qty'];
        } else {
            $product = Product::find($data['product_id']);
            $productVariant = $product->productVariants->where('sku', $data['product_sku'])->first();
            if(!$this->stockAvailable($productVariant, $data['qty'])) {
                throw new \Exception('Stock unavailable');
            }
            $carts[$data['product_sku']] = [
                'id' => $productVariant->sku,
                'product_id' => $data['product_id'],
                'product_variant_id' => $productVariant->id,
                'product_name' => $product->name,
                'product_attributes' => $productVariant->attributes->pluck('value', 'type')->toArray(),
                'qty' => $data['qty'],
                'price' => $productVariant->price,
                'discount' => 0
            ];
        }

        session()->put('carts', $carts);
    }

    public function remove($id = null)
    {
        $carts = session()->get('carts') ?? [];
        if(!$carts)
            throw new \Exception(__('Your cart is empty'));
        if(array_key_exists($id, $carts)) {
            unset($carts[$id]);
            session()->put('carts', $carts);
        } else {
            throw new \Exception(__('Cart item not found!'));
        }
        return $this->getCartItems();
    }

    public function getCartItems()
    {
        $carts = session()->get('carts') ?? [];
        return collect($carts)->values();
    }

    public function getTotal()
    {
        $carts = session()->get('carts') ?? [];
        return floor(collect($carts)->map(function($item, $key) {
            return ['total' => $item['price'] * $item['qty']];
        })->sum('total'));
    }

    public function getTotalDiscount()
    {
        $carts = session()->get('carts') ?? [];
        return floor(collect($carts)->sum('discount'));
    }

    public function getTotalItemsCount(): int
    {
        $carts = session()->get('carts') ?? [];
        return collect($carts)->sum('qty');
    }

    private function stockAvailable($productVariant, int $qty): bool
    {
        return (bool) $productVariant->stock->qty >= $qty + AppConstant::MIN_STOCK_AMOUNT;
    }

    public function clear()
    {
        session()->put('carts', []);
    }
}
