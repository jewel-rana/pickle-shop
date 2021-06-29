<?php

namespace App\Http\Controllers;

use App\Constants\AppConstant;
use App\Http\Requests\DeliveryUpdateRequest;
use App\Http\Requests\OrderDeliveryStoreRequest;
use App\Models\OrderDelivery;
use App\Services\DeliveryService;

class OrderDeliveryController extends Controller
{
    public $deliveryService;

    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    public function index()
    {
        return OrderDelivery::with(['order.customer.user', 'order.orderItems.product', 'order.orderItems.productVariant'])
            ->where('status', '=', AppConstant::DELIVERY_PENDING)
            ->all();
    }

    public function store(OrderDeliveryStoreRequest $request)
    {
        try {
            $this->deliveryService->create($request->validated());
            return response()->success(__('Delivery man assigned to order'));
        } catch (\Throwable $exception) {
            return response()->error(__('Something happened wrong', $exception->getMessage()));
        }
    }

    public function update(DeliveryUpdateRequest $request, $id)
    {
        try {
            $this->deliveryService->update($request->validated(), $id);
            return response()->success(__('Your delivery status successfully updated'));
        } catch (\Throwable $exception) {
            return response()->error(__('Something happened wrong', $exception->getMessage()));
        }
    }
}
