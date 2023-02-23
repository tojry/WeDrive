<?php

namespace App\Entity;

use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Recherche
{
    private ?string $lieuDepart;

    private ?string $lieuArrivee;

    #[Assert\Type(\DateTime::class)]
    private ?DateTimeInterface $dateDepart;

    public function getLieuDepart(): ?string
    {
        return $this->lieuDepart;
    }

    public function setLieuDepart(?string $lieuDepart): self
    {
        $this->lieuDepart = $lieuDepart;

        return $this;
    }

    public function getLieuArrivee(): ?string
    {
        return $this->lieuArrivee;
    }

    public function setLieuArrivee(?string $lieuArrivee): self
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