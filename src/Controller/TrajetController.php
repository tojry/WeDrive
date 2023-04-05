<?php

namespace App\Controller;

use App\Entity\NotifAnnulation;
use App\Entity\Trajet;

use App\Repository\TrajetRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Reponse;
use App\Entity\NotifReponse;
use App\Form\ReponseOffreType;
use App\Repository\ReponseRepository;
use App\Service\NotificationsManager;
use function PHPUnit\Framework\isEmpty;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrajetController extends AbstractController
{
    #[Route('/trajet/{id}', name: 'app_trajet')]
    public function detailsTrajet(Trajet $trajet, Request $request, EntityManagerInterface $entityManager, NotificationsManager $notifs, ReponseRepository $reponses): Response

    {
        if($trajet != null){

            $reponse = new Reponse();
            $form = $this->createForm(ReponseOffreType::class, $reponse);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $notif = new NotifReponse();

                $reponse->setDateHeureReponse(new \DateTime('now'));
                $reponse->setEtatReponse("En attente");
                $reponse->setTrajetConcerne($trajet);
                $reponse->setUtilisateurConcerne($this->getUser());
                $reponse->setNotifReponse($notif);

                $notif->setReponse($reponse);
                $notif->setUtilisateurConcerne($trajet->getCovoitureur());
                $notif->setTitreNotif("Nouvelle réponse pour un trajet");
                $notif->setTexteNotif("Vous avez reçu une nouvelle réponse pour le trajet ".$trajet->getLieuDepart()->getVille()." - ". 
                                        $trajet->getLieuArrive()->getVille()." du ".$trajet->getDateHeureDepart()->format("d/m/Y - H:i").".");
                $notif->setDateHeureNotif(new \DateTime('now'));
                $notif->setOuverte(false);

                // Sauvegarde de l'objet dans la DB   
                $entityManager->persist($reponse); 
                $entityManager->flush();

                // Envoi de la notification
                $notifs->envoyerNotifReponse($notif);

            }
          
            
            $reponse = $reponses->verifierEnvoiReponse($this->getUser(), $trajet);

            return $this->render('trajet/index.html.twig', [
                'trajet' => $trajet,
                'utilisateurActuel' => $this->getUser(),
                'today' => (new \DateTime('today'))->format('d-m-Y H:i'),
                'reponse' => $reponse,
                'form' => $form->createView(),
            ]);
                  
        }
        else return new Response('Veuillez spécifier un trajet.', 500);

    }

    #[Route('/annulation/{id}', name: 'annuler_trajet')]
    public function supprimer(Trajet $trajet, EntityManagerInterface $manager, NotificationsManager $notifs) : Response
    {
        if($trajet){
            $user = $this->getUser();

            if($user == $trajet->getCovoitureur()){
                $trajet->setAnnulee(true);
                $manager->persist($trajet);
                $manager->flush();

                return $this->redirectToRoute("app_trajet", ['id' => $trajet->getId()]);
                
            }else{
                return new Response("Vous n'êtes pas à l'origine de ce trajet.");
            }
        }else{
            return new Response("Ce trajet n'existe pas.");
        }
    }
}
