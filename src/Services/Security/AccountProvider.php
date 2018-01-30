<?php

namespace Services\Security;

use ModelBundle\Propel\Model\Account;
use ModelBundle\Propel\Model\AccountQuery;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AccountProvider implements UserProviderInterface
{
    /**
     * @param string $email
     * @return Account|UserInterface
     * @throws \Symfony\Component\Security\Core\Exception\UsernameNotFoundException
     */
    public function loadUserByUsername($email)
    {
        $account = AccountQuery::create()
            ->filterByEmail($email)
            ->findOne();
        if ($account) {
            return $account;
        }

        throw new UsernameNotFoundException(
            'Invalid login information'
        );
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

        return $account;
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