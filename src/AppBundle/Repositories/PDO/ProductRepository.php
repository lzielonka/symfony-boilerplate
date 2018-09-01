<?php

namespace AppBundle\Repositories\PDO;

use AppBundle\Database\PDO\Manager\PDOManager;
use AppBundle\Database\Propel\Model\Product;
use AppBundle\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    /** @var PDOManager */
    private $manager;
    /** @var string */
    private $modelClass;

    public function __construct(PDOManager $manager)
    {
        $this->manager = $manager;
        $this->modelClass = Product::class;
    }

    public function fetchAll()
    {
        throw new \RuntimeException('not yet implemented');
    }

    public function fetchOneById(int $productId): ?Product
    {
        throw new \RuntimeException('not yet implemented');
    }

    public function fetchLatestProducts(int $pageSize, int $page)
    {
        throw new \RuntimeException('not yet implemented');
    }
}