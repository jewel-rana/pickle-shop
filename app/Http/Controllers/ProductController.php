<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(): LengthAwarePaginator
    {
        return Product::with(['productVariants.attributes', 'productVariants.stock'])->paginate(15);
    }

    public function store(ProductStoreRequest $request): Response
    {
        try {
            $this->productService->create($request->validated());
            return response()->success(__('Product successfully created'));
        } catch (\Throwable $exception) {
            return response()->error(__('Product failed to create'), $exception->getMessage());
        }
    }

    public function show($id)
    {
        return Product::with(['productVariants.attributes', 'productVariants.stock', 'similarProducts'])->findOrFail($id);
    }

    public function update(ProductUpdateRequest $request, $id): JsonResponse
    {
        try {
            $this->productService->update($request->validated(), $id);
            return response()->success(__('Product successfully updated'));
        } catch (\Throwable $exception) {
            return response()->error(__('Product failed to update'), $exception->getMessage());
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            if(!$this->productService->delete($id)) {
                throw new \Exception(__('Product cannot be deleted'));
            }
            return response()->success(__('Product successfully deleted'));
        } catch (\Throwable $exception) {
            return response()->error(__('Product failed to delete'), $exception->getMessage());
        }
    }
}
