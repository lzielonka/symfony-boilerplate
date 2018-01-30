<?php

namespace Services\Security;

use ModelBundle\Propel\Model\Account;
use Propel\Runtime\Exception\PropelException;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AccountRegister
{
    /** @var EncoderFactoryInterface */
    private $encoderFactory;

    /**
     * @param EncoderFactoryInterface $encoderFactory
     */
    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @param Account $account
     * @return Account
     */
    public function registerAccount(Account $account)
    {
        return $this->registerByEmailAndPassword($account->getEmail(), $account->getPassword());
    }

    /**
     * @param $email
     * @param null|string $plainPassword
     * @return Account
     * @throws PropelException
     */
    public function registerByEmailAndPassword($email, $plainPassword = null)
    {
        $account = (new Account)
            ->setEmail($email);

        $encodedPassword = $this->encodePassword($account, $plainPassword);
        $account
            ->setPasswordHash($encodedPassword)
            ->save();

        return $account;
    }

    /**
     * @param UserInterface $account
     * @param $password
     * @return bool
     */
    public function encodePassword(UserInterface $account, $password)
    {
        $encoder = $this->encoderFactory->getEncoder($account);
        return $encoder->encodePassword($password, $account->getSalt());
    }
}