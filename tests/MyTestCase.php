<?php


namespace Tests;


use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderDelivery;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;

class MyTestCase extends TestCase
{
    use WithFaker;
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed');
    }

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
            $response = $this->withHeaders($this->getHeader())
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
        $this->withHeaders($this->getHeader())
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

    public function createOffer()
    {
        $this->withHeaders($this->getHeader())
            ->json('POST', 'api/offer', [
                'type' => 'discount',
                'min_order' => 2,
                'discount_type' => 'percent',
                'amount' => 10,
                'offer_start' => date('Y-m-d H:i:s'),
                'offer_end' => now()->addDays(30)->format('Y-m-d H:i:s'),
                'product_ids' => [1]
            ]);
    }

    public function getOffer()
    {
        return Offer::latest()->first();
    }

    protected function createProduct()
    {

    }
}
