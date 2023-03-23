<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\GroupeAmisRepository;
use App\Repository\UtilisateurRepository;


class ConsulterGroupesController extends AbstractController
{
    /*
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
    */

    #[Route('/groupes', name: 'app_consulter_groupes')]
    public function index(UtilisateurRepository $utilisateurRepository, GroupeAmisRepository $groupeAmisRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $mail = $this->getUser()->getUserIdentifier();
        $utilisateur = $utilisateurRepository->rechercher($mail);
        
        if ($utilisateur != null) {
            $groupes = $groupeAmisRepository->findAll();
            $groupesUtilisateur = [];

            foreach ($groupes as $groupe) {
                if ($groupe->getUtilisateurs()->contains($utilisateur)) {
                    $groupesUtilisateur[] = $groupe;
                }
            }

            return $this->render('consulter_groupes/index.html.twig', [
                'groupes' => $groupesUtilisateur,
            ]);
        } else {
            return new Response('Utilisateur actuel non trouvé', 502);
        }
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