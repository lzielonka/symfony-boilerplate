<?php

namespace AppBundle\Repositories\Interfaces;

use AppBundle\Database\Propel\Model\Product;

interface ProductRepositoryInterface
{
    public function fetchAll();
    public function fetchOneById(int $productId): ?Product;
    public function fetchLatestProducts(int $pageSize, int $page);
}