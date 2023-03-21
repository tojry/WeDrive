<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SupprimerUnGroupController extends AbstractController
{
    #[Route('/supprimer/un/group', name: 'app_supprimer_un_group')]
    public function index(): Response
    {
        return $this->render('supprimer_un_group/index.html.twig', [
            'controller_name' => 'SupprimerUnGroupController',
        ]);
    }
}
