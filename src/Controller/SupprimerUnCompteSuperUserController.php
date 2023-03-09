<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Utilisateur;

class SupprimerUnCompteSuperUserController extends AbstractController
{
    #[Route('/supprimeruncomptesuperuser', name: 'app_supprimer_un_compte_super_user')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Utilisateur::class);
        $utilisateurs = $repository->findAll();
        return $this->render('supprimer_un_compte_super_user/index.html.twig', [
            'controller_name' => 'CompteController',
            'utilisateurs' => $utilisateurs
        ]); 
    }
}
