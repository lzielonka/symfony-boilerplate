<?php

namespace AppBundle\Repositories\Propel;

use AppBundle\Database\Propel\Collection\ObjectCollection;
use AppBundle\Database\Propel\Manager\Base\AbstractModelManager;
use AppBundle\Database\Propel\Model\Product;
use AppBundle\Database\Propel\Model\ProductQuery;
use AppBundle\Repositories\Interfaces\ProductRepositoryInterface;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Util\PropelModelPager;

class ProductRepository implements ProductRepositoryInterface
{
    /** @var AbstractModelManager */
    private $modelManager;

    public function __construct(AbstractModelManager $modelManager)
    {
        $this->modelManager = $modelManager;
    }

    /**
     * @return ObjectCollection|Product[]
     */
    public function fetchAll()
    {
        $query = ProductQuery::create();

        return $this->modelManager->find($query);
    }

    /**
     * @param int $productId
     * @return Product|null
     */
    public function fetchOneById(int $productId): ?Product
    {
        $query = ProductQuery::create()->filterByProductId($productId);

        return $this->modelManager->findOne($query);
    }

    /**
     * @param int $page
     * @param int $pageSize
     * @return PropelModelPager
     */
    public function fetchLatestProducts(int $page, int $pageSize)
    {
        $query = ProductQuery::create()->orderByProductId(Criteria::DESC);

        return $this->modelManager->paginate($query, $page, $pageSize);
    }
}