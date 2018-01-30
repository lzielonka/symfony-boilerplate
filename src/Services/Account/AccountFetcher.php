<?php

namespace Services\Account;

use Repositories\Interfaces\AccountRepositoryInterface;

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

    public function fetchAllAccounts()
    {
        return $this->accountRepository->fetchAll();
    }

    public function fetchOneByEmail(string $email)
    {
        return $this->accountRepository->fetchOneByEmail($email);
    }

}