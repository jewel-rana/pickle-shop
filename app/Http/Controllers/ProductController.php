<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * @var ProductService
     */
    private $productService;
    private $message;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Product::with(['productVariants.attributes', 'productVariants.stock'])->paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductStoreRequest $request
     * @return JsonResponse
     */
    public function store(ProductStoreRequest $request): JsonResponse
    {
        try {
            $this->productService->create($request->validated());
            return response()->success(__('Product successfully created'));
        } catch (\Throwable $exception) {
            return response()->error(__('Product failed to create'), $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|Response
     */
    public function show($id)
    {
        return Product::with(['productVariants.attributes', 'productVariants.stock'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(ProductUpdateRequest $request, $id): JsonResponse
    {
        try {
            $this->productService->update($request->validated(), $id);
            return response()->success(__('Product successfully updated'));
        } catch (\Throwable $exception) {
            return response()->error(__('Product failed to update'), $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
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
