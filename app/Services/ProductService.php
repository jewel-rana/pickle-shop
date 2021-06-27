<?php


namespace App\Services;


use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductService
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
}
