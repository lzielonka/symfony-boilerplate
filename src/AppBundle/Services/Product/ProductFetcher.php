<?php

namespace AppBundle\Services\Product;

use AppBundle\Database\Propel\Model\Product;
use AppBundle\Repositories\Interfaces\ProductRepositoryInterface;

class ProductFetcher
{
    /**@var ProductRepositoryInterface */
    private $productRepository;

    /**
     * ProductFetcher constructor.
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function fetchLatestProducts($page = 1, $pageSize = 10)
    {
        return $this->productRepository->fetchLatestProducts($page, $pageSize);
    }

    public function fetchAll()
    {
        return $this->productRepository->fetchAll();
    }

    public function fetchOneById(int $productId): ?Product
    {
        return $this->productRepository->fetchOneById($productId);
    }

}