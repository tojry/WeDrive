<?php

namespace App\Entity;

use App\Repository\PointIntermediaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PointIntermediaireRepository::class)]
class PointIntermediaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'PointIntermediaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trajet $trajet = null;

    #[ORM\ManyToOne(inversedBy: 'pointIntermediaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ville $ville = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrajet(): ?Trajet
    {
        return $this->trajet;
    }

    public function setTrajet(?Trajet $trajet): self
    {
        $this->trajet = $trajet;

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

   

}
