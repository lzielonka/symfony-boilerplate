<?php

namespace AppBundle\Controller\Product;

use AppBundle\Database\Propel\Model\Product;
use AppBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    public function listAction(Request $request)
    {
        $productFetcher = $this->get('product_fetcher');
        $page = (int)($request->get('page') ?? 1);

        return $this->render('@App/Product/list.html.twig', [
            'products' => $productFetcher->fetchLatestProducts($page),
        ]);
    }

    public function newAction(Request $request)
    {
        $product = new Product;
        $form = $this->get('form.factory')->create(ProductType::class, $product);

        if ($request->isMethod(Request::METHOD_POST)) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                try {
                    $this->get('propel_manager')->save($product);
                    $this->get('email_manager')->sendProductCreationEmail();
                    $this->addFlash('success', 'new_product_created');

                    return $this->redirectToRoute('product.list');
                } catch (\Exception $e) {
                    $this->addFlash('error', 'failed_to_create_product');
                }
            }
        }

        return $this->render('@App/Product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
