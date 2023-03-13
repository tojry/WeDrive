<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SupprimerSonCompteController extends AbstractController
{
    #[Route('/supprimersoncompte', name: 'app_supprimer_son_compte')]
    public function index(): Response
    {
        return $this->render('supprimer_son_compte/index.html.twig', [
            'controller_name' => 'SupprimerSonCompteController',
        ]);
    }
}
