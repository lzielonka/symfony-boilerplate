<?php

namespace AppBundle\Controller\Security;

use AppBundle\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends Controller
{
    public function indexAction(Request $request)
    {
        $form = $this->createForm(RegisterType::class);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $account = $form->getData();
                try {
                    $this->get('account_register')->registerAccount($account);
                    $this->get('account_login')->loginAccount($account, $request);

                    return $this->redirectToRoute('homepage');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'failed_to_register_account');
                }
            }
        }

        return $this->render('@App/Security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

}