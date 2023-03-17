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

    #[Route('/groupes/{id}', name: 'app_consulter_groupe_details', methods: ['GET'])]
    public function show(int $id, GroupeAmisRepository $groupeAmisRepository): Response
    {
        $groupe = $groupeAmisRepository->find($id);

        if (!$groupe) {
            throw $this->createNotFoundException('Le groupe demandé n\'existe pas.');
        }

        return $this->render('consulter_groupes/details.html.twig', [
            'groupe' => $groupe,
        ]);
    }
}
