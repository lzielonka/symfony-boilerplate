<?php

namespace Repositories\PDO;

use ModelBundle\PDO\Manager\PDOManager;
use ModelBundle\Propel\Model\Account;
use Repositories\Interfaces\AccountRepositoryInterface;

class AccountRepository implements AccountRepositoryInterface
{
    /** @var PDOManager */
    private $manager;
    /** @var string */
    private $modelClass;

    public function __construct(PDOManager $manager)
    {
        $this->manager = $manager;
        $this->modelClass = Account::class;
    }

    public function fetchAll()
    {
        $sql = "SELECT * FROM account";
        $results = $this->manager->executeSql($sql);

        return $results->fetchAll(\PDO::FETCH_CLASS, $this->modelClass);
    }

    /**
     * @param string $email
     * @return null|Account
     */
    public function fetchOneByEmail(string $email)
    {
        $sql = "SELECT * FROM account where email = :email limit 1";
        $statement = $this->manager->executeSql($sql, [':email' => $email]);
        $result = $statement->fetchObject($this->modelClass);

        return $result === false ? null : $result;
    }
}