<?php

namespace AppBundle\Controller\Homepage;

use ModelBundle\Propel\Model\Account;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends Controller
{
    public function indexAction(Request $request)
    {
        $loginStatus = 'not logged in';
        $account = $this->getUser();
        if ($account instanceof Account) {
            $loginStatus = 'logged in as ' . $account->getEmail();
        }

        $accountFetcher = $this->get('account_fetcher');
        $accounts = $accountFetcher->fetchAllAccounts();

        return $this->render('@App/Homepage/index.html.twig', [
            'loginStatus' => $loginStatus,
            'accounts' => $accounts,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }
}
