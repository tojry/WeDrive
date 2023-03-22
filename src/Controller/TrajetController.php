<?php

namespace App\Controller;

use App\Entity\Trajet;
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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

                // Sauvegarde de l'objet dans la DB   
                $entityManager->persist($reponse); 
                $entityManager->flush();

                // Envoi de la notification
                $notifs->envoyerNotifReponse($notif);

            }

            $reponse = $reponses->verifierEnvoiReponse($this->getUser(), $trajet);

            return $this->render('trajet/index.html.twig', [
                'trajet' => $trajet,
                'reponse' => $reponse,
                'form' => $form->createView(),
            ]);
        }
        else return new Response('Veuillez spécifier un trajet.', 500);

    }
}
