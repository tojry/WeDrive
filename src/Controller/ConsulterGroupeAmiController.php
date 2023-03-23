<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UtilisateurRepository;
use App\Entity\Utilisateur;
use App\Entity\GroupeAmis;


class ConsulterGroupeAmiController extends AbstractController
{
    #[Route('/consultergroupeami/{id}', name: 'app_consulter_groupe_ami')]
    public function index(GroupeAmis $groupeAmi = null, UtilisateurRepository $utilisateurRepository = null): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); 
        $mail =  $this->getUser()->getUserIdentifier();
        $utilisateur = $utilisateurRepository->rechercher($mail);
        if($groupeAmi){
            return $this->render('consulter_groupe_ami/index.html.twig', [
                'controller_name' => 'ConsulterGroupeAmiController',
                'groupeAmi' => $groupeAmi, 
                'currentuser' => $utilisateur
            ]);
        }
        return $this->render('consulter_groupe_ami/introuvable.html.twig', [
            'controller_name' => 'ConsulterGroupeAmiController',
        ]);
    }
}
