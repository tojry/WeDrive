<?php

namespace App\Service;

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
        
    }

    public function envoyerNotifReponse(NotifReponse $notif){
        
    }

    public function envoyerNotifTrajetPrive(NotifTrajetPrive $notif){
        
    }
    
}

?>