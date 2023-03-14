<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Utilisateur;

class AfficherListeCompteSuperUserController extends AbstractController
{
    #[Route('/afficherlistecomptesuperuser', name: 'app_afficher_liste_compte_super_user')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Utilisateur::class);
        $utilisateurs = $repository->findAll();
        return $this->render('afficher_liste_compte_super_user/index.html.twig', [
            'controller_name' => 'AfficherListeCompteSuperUserController',
            'utilisateurs' => $utilisateurs
        ]);
    }
}
