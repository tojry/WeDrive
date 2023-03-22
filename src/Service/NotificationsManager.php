<?php

namespace App\Service;

use App\Entity\Utilisateur;
use App\Entity\Notification;
use App\Entity\NotifReponse;
use App\Entity\NotifAnnulation;
use App\Entity\NotifTrajetPrive;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\NotifReponseRepository;
use App\Repository\NotifAnnulationRepository;
use App\Repository\NotificationRepository;
use App\Repository\NotifTrajetPriveRepository;

class NotificationsManager
{
    private $notifs;
    private $notifsAnnulation;
    private $notifsReponse;
    private $notifsTrajetPrive;
    private $entityManager;

    public function __construct(NotificationRepository $notifs,
                                NotifAnnulationRepository $notifsAnnulation,
                                NotifReponseRepository $notifsReponse,
                                NotifTrajetPriveRepository $notifsTrajetPrive,
                                EntityManagerInterface $entityManager)
    {
        $this->notifs = $notifs;
        $this->notifsAnnulation = $notifsAnnulation;
        $this->notifsReponse = $notifsReponse;
        $this->notifsTrajetPrive = $notifsTrajetPrive;
        $this->entityManager = $entityManager;
    }

    public function envoyerNotif(Notification $notif){

        $this->entityManager->persist($notif); 
        $this->entityManager->flush();
    }

    public function envoyerNotifAnnulation(NotifAnnulation $notif){

        $this->entityManager->persist($notif); 
        $this->entityManager->flush();
    }

    public function envoyerNotifReponse(NotifReponse $notif){
        
        $this->entityManager->persist($notif); 
        $this->entityManager->flush();
    }

    public function envoyerNotifTrajetPrive(NotifTrajetPrive $notif){
        
        $this->entityManager->persist($notif); 
        $this->entityManager->flush();
    }

    public function chargerNotifs(Utilisateur $user) : array{
        
        $listeNotifs = $this->notifs->findByUser($user);
        /*array_push($listeNotifs, $this->notifsReponse->findByUser($user));
        array_push($listeNotifs, $this->notifsAnnulation->findByUser($user));
        array_push($listeNotifs, $this->notifsTrajetPrive->findByUser($user));*/

        return $listeNotifs;
    }
}

?>