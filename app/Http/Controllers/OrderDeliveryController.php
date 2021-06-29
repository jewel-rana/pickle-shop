<?php

namespace App\Http\Controllers;

use App\Constants\AppConstant;
use App\Http\Requests\OrderDeliveryStoreRequest;
use App\Models\OrderDelivery;
use App\Services\DeliveryService;
use Illuminate\Http\Request;

class OrderDeliveryController extends Controller
{
    public $deliveryService;

    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
