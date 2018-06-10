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
     * @throws PropelException
     */
    public function registerAccount(Account $formAccount)
    {
        $newAccount = new Account;
        $newAccount
            ->setEmail($formAccount->getEmail())
            ->setSalt($this->generateSalt());

        $encodedPassword = $this->encodePassword($newAccount, $formAccount->getPasswd());
        $newAccount
            ->setPasswd($encodedPassword)
            ->save();
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

    /**
     * @return string
     */
    private function generateSalt()
    {
        return substr(md5(mt_rand()), 0, 5);
    }
}