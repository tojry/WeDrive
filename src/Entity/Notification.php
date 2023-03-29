<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"discr", type:"string")]
#[ORM\DiscriminatorMap(["notification" => Notification::class, "notifAnnulation" => NotifAnnulation::class, "notifReponse" => NotifReponse::class, "notifTrajetPrive" => NotifTrajetPrive::class])]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 1024)]
    private $titreNotif;

    #[ORM\Column(type: 'string', length: 1024)]
    private $texteNotif;

    #[ORM\Column(type: 'datetime')]
    private $dateHeureNotif;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $UtilisateurConcerne = null;

    #[ORM\Column]
    private ?bool $ouverte = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUtilisateurConcerne(): ?Utilisateur
    {
        return $this->UtilisateurConcerne;
    }

    public function setUtilisateurConcerne(?Utilisateur $UtilisateurConcerne): self
    {
        $this->UtilisateurConcerne = $UtilisateurConcerne;

        return $this;
    }

    public function isOuverte(): ?bool
    {
        return $this->ouverte;
    }

    public function setOuverte(bool $ouverte): self
    {
        $this->ouverte = $ouverte;

        return $this;
    }
}
