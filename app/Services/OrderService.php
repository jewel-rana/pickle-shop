<?php


namespace App\Services;


use App\Events\OrderPlacedEvent;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\OrderDeliveryRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OrderService
{
    /**
     * @var OrderDeliveryRepository
     */
    private $deliveryRepository;
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;
    private $cartService;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        OrderDeliveryRepository $deliveryRepository,
        CartService $cartService
    )
    {
        $this->orderRepository = $orderRepository;
        $this->deliveryRepository = $deliveryRepository;
        $this->cartService = $cartService;
    }

    public function create(array $data)
    {
        DB::transaction(function () use ($data) {
            //Create user account
            $user = User::firstOrCreate(
                [
                    'email' => $data['customer_email']
                ],
                [
                    'name' => $data['customer_name'],
                    'email' => $data['customer_email'],
                    'password' => bcrypt(Str::random(8))
                ]
            );
            //save customer info
            $customer = Customer::firstOrCreate([
                'user_id' => $user->id
            ], [
                'address' => $data['customer_address']
            ]);
            //create order
            $data = [
                'customer_id' => 1,
                'total_amount' => $this->cartService->getTotal(),
                'total_payable' => $this->getPayable(),
                'discount' => $this->cartService->getTotalDiscount()
            ];
            $order = Order::create($data);
//            //save order items
            $this->orderItems()->each(function($item, $key) use($order) {
                OrderItem::create($item + ['order_id' => $order->id]);
            });
            $this->cartService->clear();
            $order->refresh();
            event(new OrderPlacedEvent($user, $order));
        }, 2);
    }

    public function update(array $data, $id)
    {
        $order = $this->orderRepository->show($id);
    }

    private function getPayable()
    {
        return floor($this->cartService->getTotal() - $this->cartService->getTotalDiscount());
    }

    private function orderItems()
    {
        return $this->cartService->getCartItems()
            ->map(function ($item, $key) {
                return [
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['product_variant_id'],
                    'qty' => $item['qty'],
                    'unit_price' => $item['price'],
                    'discount' => $item['discount'],
                    'total_price' => $item['price'] * $item['qty']
                ];
            }
            );
    }
}
