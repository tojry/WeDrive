<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsulterGroupesController extends AbstractController
{
    #[Route('/consulter/groupes', name: 'app_consulter_groupes')]
    public function index(): Response
    {
        return $this->render('consulter_groupes/index.html.twig', [
            'controller_name' => 'ConsulterGroupesController',
        ]);
    }
}
