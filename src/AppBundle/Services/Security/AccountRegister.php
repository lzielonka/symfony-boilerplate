<?php

namespace AppBundle\Services\Security;

use AppBundle\Database\Propel\Model\Account;
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
     * @param Account $formAccount
     * @return Account
     * @throws PropelException
     */
    public function registerAccount(Account $formAccount): Account
    {
        $salt = $this->generateSalt();
        $encodedPassword = $this->encodePassword($formAccount, $salt);

        $newAccount = new Account;
        $newAccount
            ->setEmail($formAccount->getEmail())
            ->setSalt($salt)
            ->setPasswd($encodedPassword)
            ->save();

        return $newAccount;
    }

    /**
     * @param UserInterface $account
     * @param $salt
     * @return string
     */
    public function encodePassword(UserInterface $account, $salt): string
    {
        $encoder = $this->encoderFactory->getEncoder($account);
        
        return $encoder->encodePassword($account->getPassword(), $salt);
    }

    /**
     * @return string
     */
    private function generateSalt(): string
    {
        return substr(md5(mt_rand()), 0, 5);
    }
}