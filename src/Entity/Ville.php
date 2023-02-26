<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VilleRepository::class)]
class Ville
{
    #[ORM\Column]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $ville = null;

    #[ORM\OneToMany(mappedBy: 'ville', targetEntity: PointIntermediaire::class)]
    private Collection $pointIntermediaires;

    public function __construct()
    {
        $this->pointIntermediaires = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdVille(): ?int
    {
        return $this->idVille;
    }

    public function setIdVille(int $idVille): self
    {
        $this->idVille = $idVille;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection<int, PointIntermediaire>
     */
    public function getPointIntermediaires(): Collection
    {
        return $this->pointIntermediaires;
    }

    public function addPointIntermediaire(PointIntermediaire $pointIntermediaire): self
    {
        if (!$this->pointIntermediaires->contains($pointIntermediaire)) {
            $this->pointIntermediaires->add($pointIntermediaire);
            $pointIntermediaire->setVille($this);
        }

        return $this;
    }

    public function removePointIntermediaire(PointIntermediaire $pointIntermediaire): self
    {
        if ($this->pointIntermediaires->removeElement($pointIntermediaire)) {
            // set the owning side to null (unless already changed)
            if ($pointIntermediaire->getVille() === $this) {
                $pointIntermediaire->setVille(null);
            }
        }

        return $this;
    }



}
