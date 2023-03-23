<?php

namespace App\Entity;

use App\Repository\NotifTrajetPriveRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotifTrajetPriveRepository::class)]
class NotifTrajetPrive extends Notification
{
    #[ORM\OneToOne(inversedBy: 'notifTrajetPrive', cascade: ['persist', 'remove'])]
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
