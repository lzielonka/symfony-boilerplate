<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends Controller
{
    public function indexAction(Request $request)
    {
        $customerFetcher = $this->get('customer_fetcher');
        $customers = $customerFetcher->fetchAllCustomers();

        return $this->render('@AppBundle/Resources/views/Homepage/index.html.twig', [
            'customers' => $customers,
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
