<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GroupeAmisRepository;

class ConsulterGroupesController extends AbstractController
{
    #[Route('/groupes', name: 'app_consulter_groupes')]
    public function index(GroupeAmisRepository $groupeAmisRepository): Response
    {
        $groupes = $groupeAmisRepository->findAll();

        return $this->render('consulter_groupes/index.html.twig', [
            'groupes' => $groupes,
        ]);
    }

}
