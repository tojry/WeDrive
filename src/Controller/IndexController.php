<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/',name: 'app_home')]
    public function number(RequestStack $requestStack): Response
    {

        $session = $requestStack->getSession();




        return $this->render('index.html.twig');
    }
}