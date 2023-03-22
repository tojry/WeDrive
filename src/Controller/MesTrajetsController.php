<?php

namespace App\Controller;

use App\Repository\TrajetRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesTrajetsController extends AbstractController
{
    #[Route('/mestrajets', name: 'app_mes_trajets')]
    public function index(UtilisateurRepository $utilisateurRepository, TrajetRepository $trajetRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $mail =  $this->getUser()->getUserIdentifier();
        $utilisateur = $utilisateurRepository->rechercher($mail);

        if($utilisateur != null){
            
            $trajetsPasses = $trajetRepository->getTrajetsPassesUtilisateur($utilisateur->getId());
            $trajetsFuturs = $trajetRepository->getTrajetsFutursUtilisateur($utilisateur->getId());
            
            return $this->render('mes_trajets/index.html.twig', [
                'controller_name' => 'MesTrajetsController',
                'trajetsPasses' => $trajetsPasses,
                'trajetsFuturs' => $trajetsFuturs
            ]);
        }

        return new Response('Utilisateur introuvable');
    }
}
