<?php

namespace Repositories\Propel;

use ModelBundle\Propel\Manager\Base\AbstractModelManager;
use ModelBundle\Propel\Model\CustomerQuery;
use Repositories\Interfaces\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    private $modelManager;

    public function __construct(AbstractModelManager $modelManager)
    {
        $this->modelManager = $modelManager;
    }

    public function fetchAll()
    {
        $query = CustomerQuery::create();

        return $this->modelManager->find($query);
    }
}