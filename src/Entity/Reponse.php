<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $texteReponse = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateHeureReponse = null;

    #[ORM\Column(length: 20)]
    private ?string $etatReponse = null;

    #[ORM\ManyToOne(inversedBy: 'reponses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateurConcerne = null;

    #[ORM\ManyToOne(inversedBy: 'reponses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trajet $trajetConcerne = null;

    #[ORM\OneToOne(mappedBy: 'Reponse', cascade: ['persist', 'remove'])]
    private ?NotifReponse $notifReponse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexteReponse(): ?string
    {
        return $this->texteReponse;
    }

    public function setTexteReponse(?string $texteReponse): self
    {
        $this->texteReponse = $texteReponse;

        return $this;
    }

    public function getDateHeureReponse(): ?\DateTimeInterface
    {
        return $this->dateHeureReponse;
    }

    public function setDateHeureReponse(\DateTimeInterface $dateHeureReponse): self
    {
        $this->dateHeureReponse = $dateHeureReponse;

        return $this;
    }

    public function getEtatReponse(): ?string
    {
        return $this->etatReponse;
    }

    public function setEtatReponse(string $etatReponse): self
    {
        $this->etatReponse = $etatReponse;

        return $this;
    }

    public function getUtilisateurConcerne(): ?Utilisateur
    {
        return $this->utilisateurConcerne;
    }

    public function setUtilisateurConcerne(?Utilisateur $utilisateurConcerne): self
    {
        $this->utilisateurConcerne = $utilisateurConcerne;

        return $this;
    }

    public function getTrajetConcerne(): ?Trajet
    {
        return $this->trajetConcerne;
    }

    public function setTrajetConcerne(?Trajet $trajetConcerne): self
    {
        $this->trajetConcerne = $trajetConcerne;

        return $this;
    }

    public function getNotifReponse(): ?NotifReponse
    {
        return $this->notifReponse;
    }

    public function setNotifReponse(?NotifReponse $notifReponse): self
    {
        // unset the owning side of the relation if necessary
        if ($notifReponse === null && $this->notifReponse !== null) {
            $this->notifReponse->setReponse(null);
        }

        // set the owning side of the relation if necessary
        if ($notifReponse !== null && $notifReponse->getReponse() !== $this) {
            $notifReponse->setReponse($this);
        }

        $this->notifReponse = $notifReponse;

        return $this;
    }


}