<?php

namespace App\Entity;

use App\Repository\NotifReponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotifReponseRepository::class)]
class NotifReponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'notifReponse', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reponse $Reponse = null;

    #[ORM\ManyToOne(inversedBy: 'notifreponses')]
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

    public function getReponse(): ?Reponse
    {
        return $this->Reponse;
    }

    public function setReponse(Reponse $Reponse): self
    {
        $this->Reponse = $Reponse;

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
