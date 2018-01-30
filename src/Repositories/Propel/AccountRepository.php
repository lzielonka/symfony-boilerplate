<?php

namespace Repositories\Propel;

use ModelBundle\Propel\Collection\ObjectCollection;
use ModelBundle\Propel\Manager\Base\AbstractModelManager;
use ModelBundle\Propel\Model\Account;
use ModelBundle\Propel\Model\AccountQuery;
use Repositories\Interfaces\AccountRepositoryInterface;

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