<?php

namespace Repositories\PDO;

use ModelBundle\PDO\Manager\PDOManager;
use Repositories\Interfaces\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    /** @var PDOManager */
    private $manager;

    public function __construct(PDOManager $manager)
    {
        $this->manager = $manager;
    }
    public function fetchAll()
    {
        $sql = "SELECT * FROM customer";
        $results = $this->manager->executeSql($sql);

        return $results->fetchAll();
    }
}