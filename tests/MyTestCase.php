<?php


namespace Tests;


use App\Models\Order;
use App\Models\OrderDelivery;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;

class MyTestCase extends TestCase
{
    use WithFaker;
    protected function getHeader(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'json'
        ];
    }

    protected function getAProduct()
    {
        return Product::all()->first();
    }

    public function addToCart(): bool
    {
        $product = $this->getAProduct();
        if($product) {
            $this->withHeaders($this->getHeader())
                ->json('POST', 'api/cart', [
                    'product_id' => $product->id,
                    'product_sku' => $product->productVariants->first()->sku,
                    'qty' => 2
                ]);
            return true;
        }
        return false;
    }

    public function placeOrder()
    {
        $this->addToCart();
        $response = $this->withHeaders($this->getHeader())
            ->json('POST', '/api/order', [
                'customer_name' => $this->faker()->name(),
                'customer_email' => $this->faker()->email(),
                'customer_address' => $this->faker()->address
            ]);
    }

    public function getOrder()
    {
        return Order::all()->first();
    }

    public function assignDeliveryMan()
    {
        $this->placeOrder();
        $order = $this->getOrder();
        $response = $this->withHeaders($this->getHeader())
            ->json('POST', 'api/order/delivery', [
                'order_id' => $order->id,
                'delivery_man_name' => $this->faker()->name(),
                'delivery_man_mobile' => '01911785317'
            ]);
    }

    public function getDelivery()
    {
        return OrderDelivery::latest()->first();
    }

    protected function createProduct()
    {

    }
}
