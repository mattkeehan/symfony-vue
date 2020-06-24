<?php

namespace App\Controller;

use App\Controller\TokenAuthenticatedController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class FooController extends AbstractController implements TokenAuthenticatedController
{
    /**
     * @Route("/foo/bar")
     */
    public function bar()
    {
      return $this->render('product/index.html.twig', [
        'product' => 'poo poo poo'
      ]);

    }
}