<?php

namespace AppBundle\Repositories\Propel;

use AppBundle\Database\Propel\Collection\ObjectCollection;
use AppBundle\Database\Propel\Manager\Base\AbstractModelManager;
use AppBundle\Database\Propel\Model\Account;
use AppBundle\Database\Propel\Model\AccountQuery;
use AppBundle\Repositories\Interfaces\AccountRepositoryInterface;

class AccountRepository implements AccountRepositoryInterface
{
    private $modelManager;

    public function __construct(AbstractModelManager $modelManager)
    {
        $this->modelManager = $modelManager;
    }

    /**
     * @return ObjectCollection|Account[]
     */
    public function fetchAll()
    {
        $query = AccountQuery::create();

        return $this->modelManager->find($query);
    }

    /**
     * @param string $email
     * @return Account|null
     */
    public function fetchOneByEmail(string $email)
    {
        $query = AccountQuery::create()->filterByEmail($email);

        return $this->modelManager->findOne($query);
    }
}