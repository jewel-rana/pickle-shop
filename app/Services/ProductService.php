<?php


namespace App\Services;

use App\Models\SimilarProduct;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductService
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    private $productVariantService;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        ProductVariantService $productVariantService
    )
    {
        $this->productRepository = $productRepository;
        $this->productVariantService = $productVariantService;
    }

    public function create(array $data): bool
    {
        DB::transaction(function () use ($data) {
            $product = $this->productRepository->create($data);
            collect($data['variants'])->each(function ($item, $key) use ($product) {
                $this->productVariantService->create($item, $product);
            });
            if (request()->has('similar_product_ids')) {
                $product->similarProducts()->attach($data['similar_product_ids']);
            }
            $product->refresh();
            return true;
        }, 3);
        return false;
    }

    public function update(array $data, int $id): bool
    {
        DB::transaction(function () use ($data, $id) {
            $this->productRepository->update($data, $id);
//            collect($data['variants'])->each(function ($item, $key) use ($id) {
//                return $this->productVariantService->update($item, $id);
//            });
            return true;
        }, 3);
        return false;
    }

    public function delete(int $id)
    {
        return $this->productRepository->delete($id);
    }
}
