<?php

namespace App\Entity;

use App\Repository\NotifAnnulationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotifAnnulationRepository::class)]
class NotifAnnulation extends Notification
{
    #[ORM\OneToOne(inversedBy: 'notifAnnulation', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trajet $trajetConcerne = null;


    public function getTrajetConcerne(): ?Trajet
    {
        return $this->trajetConcerne;
    }

    public function setTrajetConcerne(Trajet $trajetConcerne): self
    {
        $this->trajetConcerne = $trajetConcerne;

        return $this;
    }
}
