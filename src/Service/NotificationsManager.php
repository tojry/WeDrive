<?php

namespace App\Service;

use App\Entity\Utilisateur;
use App\Entity\NotifReponse;
use App\Entity\NotifAnnulation;
use App\Entity\NotifTrajetPrive;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\NotifReponseRepository;
use App\Repository\NotifAnnulationRepository;
use App\Repository\NotifTrajetPriveRepository;

class NotificationsManager
{
    private $notifsAnnulation;
    private $notifsReponse;
    private $notifsTrajetPrive;
    private $entityManager;

    public function __construct(NotifAnnulationRepository $notifsAnnulation,
                                NotifReponseRepository $notifsReponse,
                                NotifTrajetPriveRepository $notifsTrajetPrive,
                                EntityManagerInterface $entityManager)
    {
        $this->notifsAnnulation = $notifsAnnulation;
        $this->notifsReponse = $notifsReponse;
        $this->notifsTrajetPrive = $notifsTrajetPrive;
        $this->entityManager = $entityManager;
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
        
        $listeNotifs = $this->notifsReponse->findByUser($user);

        return $listeNotifs;
    }
}

?>