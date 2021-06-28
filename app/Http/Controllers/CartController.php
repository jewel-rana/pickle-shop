<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartStoreRequest;
use App\Services\CartService;

class CartController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function store(CartStoreRequest $request)
    {
        try {
            $this->cartService->add($request->validated());
            return response()->success(__('Your item successfully added to cart'),
                [
                    'carts' => $this->cartService->getCartItems(),
                    'total_items' => $this->cartService->getTotalItemsCount(),
                    'total_amount' => $this->cartService->getTotal(),
                    'total_discount' => $this->cartService->getTotalDiscount()
                ]
            );
        } catch (\Throwable $exception) {
            return response()->error(__('Failed to add cart'), $exception->getMessage());
        }
    }

    public function destroy($id = null)
    {
        return $this->cartService->remove($id);
    }
}
