<?php

namespace App\Entity;

use App\Repository\NotifTrajetPriveRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotifTrajetPriveRepository::class)]
class NotifTrajetPrive
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'notifTrajetPrive', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trajet $trajetConcerne = null;

    #[ORM\ManyToOne(inversedBy: 'notifTrajetsPrives')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $UtilisateurConcerne = null;

    #[ORM\Column(type: 'string', length: 1024)]
    private $titreNotif;

    #[ORM\Column(type: 'string', length: 1024)]
    private $texteNotif;

    #[ORM\Column(type: 'datetime')]
    private $dateHeureNotif;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrajetConcerne(): ?Trajet
    {
        return $this->trajetConcerne;
    }

    public function setTrajetConcerne(Trajet $trajetConcerne): self
    {
        $this->trajetConcerne = $trajetConcerne;

        return $this;
    }

    public function getUtilisateurConcerne(): ?Utilisateur
    {
        return $this->UtilisateurConcerne;
    }

    public function setUtilisateurConcerne(?Utilisateur $UtilisateurConcerne): self
    {
        $this->UtilisateurConcerne = $UtilisateurConcerne;

        return $this;
    }

    public function getTitreNotif(): ?string
    {
        return $this->titreNotif;
    }

    public function setTitreNotif(string $titreNotif): self
    {
        $this->titreNotif = $titreNotif;

        return $this;
    }

    public function getTexteNotif(): ?string
    {
        return $this->texteNotif;
    }

    public function setTexteNotif(string $texteNotif): self
    {
        $this->texteNotif = $texteNotif;

        return $this;
    }

    public function getDateHeureNotif(): ?\DateTimeInterface
    {
        return $this->dateHeureNotif;
    }

    public function setDateHeureNotif(\DateTimeInterface $dateHeureNotif): self
    {
        $this->dateHeureNotif = $dateHeureNotif;

        return $this;
    }
}
