<?php

namespace AppBundle\Services\Account;

use AppBundle\Repositories\Interfaces\AccountRepositoryInterface;

class AccountFetcher
{
    /**@var AccountRepositoryInterface */
    private $accountRepository;

    /**
     * AccountFetcher constructor.
     * @param AccountRepositoryInterface $accountRepository
     */
    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function fetchAll()
    {
        return $this->accountRepository->fetchAll();
    }

    public function fetchOneByEmail(string $email)
    {
        return $this->accountRepository->fetchOneByEmail($email);
    }

}