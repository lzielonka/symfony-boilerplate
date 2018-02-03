<?php

namespace AppBundle\Controller\Security;

use AppBundle\Database\Propel\Model\Account;
use AppBundle\Form\AccountType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends Controller
{
    public function indexAction(Request $request)
    {
        $form = $this->createForm(AccountType::class);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $account = $form->getData();
                /** @var Account $account */
                $alreadyExists = $this->get('account_fetcher')->fetchOneByEmail($account->getEmail());
                if (!$alreadyExists) {
                    $this->get('account_register')->registerAccount($account);
                    $this->get('account_login')->authenticateByUser($account, $request);

                    return $this->redirectToRoute('homepage');
                }

                $this->addFlash('error', 'email already in use');
            }
        }

        return $this->render('@App/Security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

}