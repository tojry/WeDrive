<?php

namespace App\Controller;

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
    public function afficher(NotifReponse $notif, Request $request, NotificationsManager $notifs) : Response {

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
        $notifAccepter->setUtilisateurConcerne($trajet->getCovoitureur());
        $notifAccepter->setTitreNotif("Votre demande a été acceptée");
        $notifAccepter->setTexteNotif("Vous demande pour le trajet ".$trajet->getLieuDepart()->getVille()." - ". 
                                $trajet->getLieuArrive()->getVille()." du ".$trajet->getDateHeureDepart()->format("d/m/Y - H:i")." a été acceptée.\n
                                Vous pouvez prendre contact avec le conducteur au ".$trajet->getCovoitureur()->getNoTel().".\n Bon voyage !");
        $notifAccepter->setDateHeureNotif(new \DateTime('now'));

        $notifs->envoyerNotif($notifAccepter);

        $notif->getReponse()->setEtatReponse("Acceptée");

        $trajet->diminuerPlacesDispo();
        $trajet->addUtilisateur($notif->getReponse()->getUtilisateurConcerne());
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
        $notifRefuser = new Notification();
        $notifRefuser->setUtilisateurConcerne($trajet->getCovoitureur());
        $notifRefuser->setTitreNotif("Votre demande a été refusée");
        $notifRefuser->setTexteNotif("Vous demande pour le trajet ".$trajet->getLieuDepart()->getVille()." - ". 
                                $trajet->getLieuArrive()->getVille()." du ".$trajet->getDateHeureDepart()->format("d/m/Y - H:i")." a été refusée.\n");
        $notifRefuser->setDateHeureNotif(new \DateTime('now'));

        $notifs->envoyerNotif($notifRefuser);

        $notif->getReponse()->setEtatReponse("Refusée");
        $entityManager->persist($notif->getReponse());
        $entityManager->flush();

        return $this->render('notif.html.twig', [
            'notif' => $notif,
        ]);
    }
}
?>