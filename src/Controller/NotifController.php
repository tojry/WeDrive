<?php

namespace App\Controller;

use App\Entity\Trajet;
use App\Entity\Utilisateur;
use App\Entity\Notification;
use App\Entity\NotifReponse;
use App\Entity\NotifAnnulation;
use App\Entity\NotifTrajetPrive;
use App\Service\NotificationsManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NotifController extends AbstractController {
 
    #[Route('/notification/{id}', name: 'notification')]
    public function afficher(Notification $notif, Request $request, NotificationsManager $notifs) : Response {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('notif.html.twig', [
            'notif' => $notif,
        ]);
    }

    #[Route('/notification/accepter/{id}', name: 'accepter_notification')]
    public function accepter(NotifReponse $notif, NotificationsManager $notifs, EntityManagerInterface $entityManager) : Response {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $trajet = $notif->getReponse()->getTrajetConcerne();
        $notifAccepter = new Notification();
        $notifAccepter->setUtilisateurConcerne($notif->getReponse()->getUtilisateurConcerne());
        $notifAccepter->setTitreNotif("Votre demande a été acceptée");
        $notifAccepter->setTexteNotif("Vous demande pour le trajet ".$trajet->getLieuDepart()->getVille()." - ". 
                                $trajet->getLieuArrive()->getVille()." du ".$trajet->getDateHeureDepart()->format("d/m/Y - H:i")." a été acceptée.\n
                                Vous pouvez prendre contact avec le conducteur au ".$trajet->getCovoitureur()->getNoTel().".\n Bon voyage !");
        $notifAccepter->setDateHeureNotif(new \DateTime('now'));

        $notifs->envoyerNotif($notifAccepter);

        $notif->getReponse()->setEtatReponse("Acceptée");

        $trajet->diminuerPlacesDispo();
        $trajet->addUtilisateur($notif->getReponse()->getUtilisateurConcerne());

        // Refus de toutes les réponses en attente si la capacité max est atteinte
        if($trajet->getPlacesDispo() <= 0){
            foreach($trajet->getReponses() as $rep){
                if($rep->getEtatReponse() === "En attente"){

                    $this->envoiNotifRefus($notif->getReponse()->getUtilisateurConcerne(), $trajet, $notifs);
                    $rep->setEtatReponse("Refusée");
                    $entityManager->persist($rep);
                }
            }
        }
        $entityManager->persist($trajet);
        $entityManager->persist($notif->getReponse());
        $entityManager->flush();


        return $this->render('notif.html.twig', [
            'notif' => $notif,
        ]);
    }

    #[Route('/notification/refuser/{id}', name: 'refuser_notification')]
    public function refuser(NotifReponse $notif, NotificationsManager $notifs, EntityManagerInterface $entityManager) : Response {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $trajet = $notif->getReponse()->getTrajetConcerne();
        $this->envoiNotifRefus($notif->getReponse()->getUtilisateurConcerne(), $trajet, $notifs);

        $notif->getReponse()->setEtatReponse("Refusée");
        $entityManager->persist($notif->getReponse());
        $entityManager->flush();

        return $this->render('notif.html.twig', [
            'notif' => $notif,
        ]);
    }

    private function envoiNotifRefus(Utilisateur $user, Trajet $trajet, NotificationsManager $notifs){
        $notifRefuser = new Notification();
        $notifRefuser->setUtilisateurConcerne($user);
        $notifRefuser->setTitreNotif("Votre demande a été refusée");
        $notifRefuser->setTexteNotif("Vous demande pour le trajet ".$trajet->getLieuDepart()->getVille()." - ". 
                                $trajet->getLieuArrive()->getVille()." du ".$trajet->getDateHeureDepart()->format("d/m/Y - H:i")." a été refusée.\n");
        $notifRefuser->setDateHeureNotif(new \DateTime('now'));

        $notifs->envoyerNotif($notifRefuser);
    }
}
?>