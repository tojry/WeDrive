<?php

namespace App\Controller;

use App\Entity\Trajet;
use App\Repository\TrajetRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function PHPUnit\Framework\isEmpty;

class TrajetController extends AbstractController
{
    #[Route('/trajet/{id}', name: 'app_trajet')]
    public function detailsTrajet(Trajet $trajet, UtilisateurRepository $utilisateurs): Response
    {
        if($trajet != null){

            $lieuDepart = $trajet->getLieuDepart();
            $pointsIntermediaires = $trajet->getPointIntermediaires();
            $isEmpty = true;
            $listePoints='';
            $i = 0;
            foreach($pointsIntermediaires as $pt){
                $i++;
                $isEmpty = false;
                $villePt = $pt->getVille();
                $listePoints .= '<li id="pt_'.$i.'">'.$villePt->getVille().' ('.$villePt->getCodePostal().')'.'</li>';
            }

            $lieuArrive = $trajet->getLieuArrive();
            $covoitureur = $trajet->getCovoitureur();
            $date = $trajet->getDateHeureDepart();
            
            $utilisateur = null;
            $mail = $this->getUser()->getUserIdentifier();
            if($mail != null && $mail != ""){
                $utilisateur = $utilisateurs->findOneBy(['adresseMail' => $mail]);
                if($utilisateur == null) return new Response('Erreur Lors de la récupération de l\'utilisateur actuel', 501);
            }

            return $this->render('trajet/index.html.twig', [
                'controller_name' => 'TrajetController',
                'trajet' => $trajet,
                'lieuDepart' => $lieuDepart->getVille().' ('.$lieuDepart->getCodePostal().')',
                'listePointsIntermediaires' => $listePoints,
                'lieuArrive' => $lieuArrive->getVille().' ('.$lieuArrive->getCodePostal().')',
                'utilisateurActuel' => $utilisateur,
                'date' => $date->format('d-m-Y H:i'),
                'today' => (new \DateTime('today'))->format('d-m-Y H:i'), 
                'hidden' => ($isEmpty)?('hidden'):('')
            ]);
        }
        else return new Response('Veuillez spécifier un trajet.', 500);

    }
}
