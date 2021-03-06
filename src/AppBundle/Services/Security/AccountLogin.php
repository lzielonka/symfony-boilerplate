<?php

namespace AppBundle\Services\Security;

use AppBundle\Database\Propel\Model\Account;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AccountLogin
{
    /** @var TokenStorageInterface */
    private $tokenStorage;
    /** @var Session */
    private $session;
    /** @var EventDispatcherInterface */
    private $dispatcher;

    /**
     * @param TokenStorageInterface $securityContext
     * @param SessionInterface $session
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        TokenStorageInterface $securityContext,
        SessionInterface $session,
        EventDispatcherInterface $dispatcher
    ) {
        $this->tokenStorage = $securityContext;
        $this->session = $session;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param Account $account
     * @param Request $request
     * @throws \InvalidArgumentException
     */
    public function loginAccount(Account $account, Request $request)
    {
        $token = new UsernamePasswordToken($account, null, 'secured_area', $account->getRoles());
        $this->tokenStorage->setToken($token);

        $event = new InteractiveLoginEvent($request, $token);
        $this->dispatcher->dispatch(SecurityEvents::INTERACTIVE_LOGIN, $event);
    }

    public function logout()
    {
        $this->session->remove('_security_secured_area');
    }
}