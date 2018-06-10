<?php

namespace AppBundle\Controller\Homepage;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends Controller
{
    public function indexAction(Request $request)
    {
        $accountFetcher = $this->get('account_fetcher');
        $accounts = $accountFetcher->fetchAllAccounts();

        return $this->render('@App/Homepage/index.html.twig', [
            'accounts' => $accounts,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }
}
