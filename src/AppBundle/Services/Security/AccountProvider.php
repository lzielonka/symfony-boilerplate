<?php

namespace AppBundle\Services\Security;

use AppBundle\Database\Propel\Model\Account;
use AppBundle\Services\Account\AccountFetcher;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AccountProvider implements UserProviderInterface
{
    /** @var AccountFetcher */
    private $accountFetcher;

    public function __construct(AccountFetcher $accountFetcher)
    {
        $this->accountFetcher = $accountFetcher;
    }

    /**
     * @param string $email
     * @return Account|UserInterface
     * @throws \Symfony\Component\Security\Core\Exception\UsernameNotFoundException
     */
    public function loadUserByUsername($email)
    {
        $account = $this->accountFetcher->fetchOneByEmail($email);
        if (!$account) {
            throw new UsernameNotFoundException('Invalid login information');
        }

        return $account;
    }

    /**
     * @param UserInterface $account
     * @return UserInterface
     * @throws \Symfony\Component\Security\Core\Exception\UnsupportedUserException
     */
    public function refreshUser(UserInterface $account)
    {
        if (!$account instanceof Account) {
            throw new UnsupportedUserException('Invalid account');
        }

        return $this->loadUserByUsername($account->getEmail());
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === Account::class;
    }
}