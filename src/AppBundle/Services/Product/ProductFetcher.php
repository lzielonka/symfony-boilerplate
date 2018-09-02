<?php

namespace AppBundle\Services\Product;

use AppBundle\Database\Propel\Model\Product;
use AppBundle\Repositories\Interfaces\ProductRepositoryInterface;

class ProductFetcher
{
    public const DEFAULT_PAGE_SIZE = 10;
    
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

    public function fetchLatestProducts(int $page = 1, int $pageSize = self::DEFAULT_PAGE_SIZE)
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