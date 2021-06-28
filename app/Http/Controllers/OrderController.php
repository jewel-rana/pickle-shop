<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $orderService;
    public function __construct(
        OrderService $orderService
    )
    {
        $this->orderService = $orderService;
    }

    public function index(): LengthAwarePaginator
    {
        return Order::with(['orderItems.product.productVariants'])->paginate(15);
    }

    public function store(OrderStoreRequest $request)
    {
        try {
            $this->orderService->create($request->validated());
            return response()->success(__('You have successfully placed an order'));
        } catch (\Throwable $exception) {
            return response()->error(__('Cannot place order'), $exception->getMessage());
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
