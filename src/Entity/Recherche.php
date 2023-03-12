<?php

namespace App\Entity;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Recherche
{
    private ?Ville $lieuDepart = null;

    private ?Ville $lieuArrivee = null;

    #[Assert\Type(\DateTime::class)]
    private ?DateTimeInterface $dateDepart = null;

    public function getLieuDepart(): ?Ville
    {
        return $this->lieuDepart;
    }

    public function setLieuDepart(?Ville $lieuDepart): self
    {
        $this->lieuDepart = $lieuDepart;

        return $this;
    }

    public function getLieuArrivee(): ?Ville
    {
        return $this->lieuArrivee;
    }

    public function setLieuArrivee(?Ville $lieuArrivee): self
    {
        $this->lieuArrivee = $lieuArrivee;

        return $this;
    }

    public function getDateDepart(): ?DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(?DateTimeInterface $dateDepart): self
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }
}
?>