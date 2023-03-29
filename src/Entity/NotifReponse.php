<?php

namespace App\Entity;

use App\Repository\NotifReponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotifReponseRepository::class)]
class NotifReponse extends Notification
{
    #[ORM\OneToOne(inversedBy: 'notifreponses', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reponse $Reponse = null;

    public function getReponse(): ?Reponse
    {
        return $this->Reponse;
    }

    public function setReponse(Reponse $Reponse): self
    {
        $this->Reponse = $Reponse;

        return $this;
    }
}
