<?php

namespace AppBundle\Repositories\Interfaces;

use AppBundle\Database\Propel\Model\Account;

interface AccountRepositoryInterface
{
    public function fetchAll();
    public function fetchOneByEmail(string $email): ?Account;
}