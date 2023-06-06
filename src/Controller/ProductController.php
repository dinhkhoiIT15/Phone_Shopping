<?php

namespace App\Controller;

use App\Entity\Phone;
use App\Entity\Product;
use App\Form\AddPhoneType;
use App\Form\AddProductType;
use App\Repository\PhoneRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/product/add', name: 'app_product_add', priority: 1)]
    public function addAction(Request $request, ProductRepository $productRepository, SluggerInterface $slugger):Response
    {
        $form = $this->createForm(AddProductType::class, new Product());
        $form->handleRequest($request);
        return $this->render('product/index.html.twig',[
            'form'=>$form
        ]);
    }
}
