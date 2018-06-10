<?php

namespace AppBundle\Controller\Api\Accounts;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AccountsController extends Controller
{
    public function indexAction(Request $request)
    {
        $accountFetcher = $this->get('account_fetcher');
        $accounts = $accountFetcher->fetchAllAccounts();

        return new JsonResponse(json_encode($accounts));
    }
}
