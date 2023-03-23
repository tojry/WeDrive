<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvaluationRepository::class)]
class Evaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $note = null;

    #[ORM\ManyToOne(targetEntity: Trajet::class,inversedBy: 'notes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trajet $idTrajet = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class,inversedBy: 'notes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $idEvaluateur = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class,inversedBy: 'notesrecus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $idEvalue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getIdTrajet(): ?Trajet
    {
        return $this->idTrajet;
    }

    public function setIdTrajet(?Trajet $idTrajet): self
    {
        $this->idTrajet = $idTrajet;

        return $this;
    }

    public function getIdEvaluateur(): ?Utilisateur
    {
        return $this->idEvaluateur;
    }

    public function setIdEvaluateur(?Utilisateur $idEvaluateur): self
    {
        $this->idEvaluateur = $idEvaluateur;

        return $this;
    }

    public function getIdEvalue(): ?Utilisateur
    {
        return $this->idEvalue;
    }

    public function setIdEvalue(?Utilisateur $idEvalue): self
    {
        $this->idEvalue = $idEvalue;

        return $this;
    }
}
