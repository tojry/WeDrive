<?php

namespace App\Entity;

use App\Repository\TrajetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrajetRepository::class)]
class Trajet
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $lieuDepart = null;

    #[ORM\Column(length: 500)]
    private ?string $lieuArrive = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateHeureDepart = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\Column]
    private ?int $capaciteMax = null;

    #[ORM\Column(length: 1024)]
    private ?string $precisionLieuRdv = null;

    #[ORM\Column(length: 1024)]
    private ?string $commentaire = null;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class, inversedBy: 'trajets')]
    #[ORM\JoinTable(name: 'participation')]
    #[ORM\JoinColumn(name: 'id_offre', referencedColumnName: "id")]
    #[ORM\InverseJoinColumn(name: 'id_utilisateur', referencedColumnName: "id")]
    private Collection $utilisateurs;

    #[ORM\OneToMany(mappedBy: 'trajet', targetEntity: PointIntermediare::class)]
    private Collection $pointIntermediares;

    #[ORM\ManyToOne(inversedBy: 'trajetProposés')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $Covoitureur = null;

    #[ORM\OneToMany(mappedBy: 'trajetConcerne', targetEntity: Reponse::class)]
    private Collection $reponses;

    #[ORM\OneToOne(mappedBy: 'trajetConcerne', cascade: ['persist', 'remove'])]
    private ?NotifTrajetPrive $notifTrajetPrive = null;

    #[ORM\OneToOne(mappedBy: 'trajetConcerne', cascade: ['persist', 'remove'])]
    private ?NotifAnnulation $notifAnnulation = null;

    #[ORM\ManyToOne(inversedBy: 'trajets')]
    private ?GroupeAmis $groupeAmi = null;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
        $this->pointIntermediares = new ArrayCollection();
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLieuDepart(): ?string
    {
        return $this->lieuDepart;
    }

    public function setLieuDepart(string $lieuDepart): self
    {
        $this->lieuDepart = $lieuDepart;

        return $this;
    }

    public function getLieuArrive(): ?string
    {
        return $this->lieuArrive;
    }

    public function setLieuArrive(string $lieuArrive): self
    {
        $this->lieuArrive = $lieuArrive;

        return $this;
    }

    public function getDateHeureDepart(): ?\DateTimeInterface
    {
        return $this->dateHeureDepart;
    }

    public function setDateHeureDepart(\DateTimeInterface $dateHeureDepart): self
    {
        $this->dateHeureDepart = $dateHeureDepart;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getCapaciteMax(): ?int
    {
        return $this->capaciteMax;
    }

    public function setCapaciteMax(int $capaciteMax): self
    {
        $this->capaciteMax = $capaciteMax;

        return $this;
    }

    public function getPrecisionLieuRdv(): ?string
    {
        return $this->precisionLieuRdv;
    }

    public function setPrecisionLieuRdv(string $precisionLieuRdv): self
    {
        $this->precisionLieuRdv = $precisionLieuRdv;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        $this->utilisateurs->removeElement($utilisateur);

        return $this;
    }

    /**
     * @return Collection<int, PointIntermediare>
     */
    public function getPointIntermediares(): Collection
    {
        return $this->pointIntermediares;
    }

    public function addPointIntermediare(PointIntermediare $pointIntermediare): self
    {
        if (!$this->pointIntermediares->contains($pointIntermediare)) {
            $this->pointIntermediares->add($pointIntermediare);
            $pointIntermediare->setTrajet($this);
        }

        return $this;
    }

    public function removePointIntermediare(PointIntermediare $pointIntermediare): self
    {
        if ($this->pointIntermediares->removeElement($pointIntermediare)) {
            // set the owning side to null (unless already changed)
            if ($pointIntermediare->getTrajet() === $this) {
                $pointIntermediare->setTrajet(null);
            }
        }

        return $this;
    }

    public function getCovoitureur(): ?Utilisateur
    {
        return $this->Covoitureur;
    }

    public function setCovoitureur(?Utilisateur $Covoitureur): self
    {
        $this->Covoitureur = $Covoitureur;

        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses->add($reponse);
            $reponse->setTrajetConcerne($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getTrajetConcerne() === $this) {
                $reponse->setTrajetConcerne(null);
            }
        }

        return $this;
    }

    public function getNotifTrajetPrive(): ?NotifTrajetPrive
    {
        return $this->notifTrajetPrive;
    }

    public function setNotifTrajetPrive(?NotifTrajetPrive $notifTrajetPrive): self
    {
        // unset the owning side of the relation if necessary
        if ($notifTrajetPrive === null && $this->notifTrajetPrive !== null) {
            $this->notifTrajetPrive->setTrajetConcerne(null);
        }

        // set the owning side of the relation if necessary
        if ($notifTrajetPrive !== null && $notifTrajetPrive->getTrajetConcerne() !== $this) {
            $notifTrajetPrive->setTrajetConcerne($this);
        }

        $this->notifTrajetPrive = $notifTrajetPrive;

        return $this;
    }

    public function getNotifAnnulation(): ?NotifAnnulation
    {
        return $this->notifAnnulation;
    }

    public function setNotifAnnulation(?NotifAnnulation $notifAnnulation): self
    {
        // unset the owning side of the relation if necessary
        if ($notifAnnulation === null && $this->notifAnnulation !== null) {
            $this->notifAnnulation->setTrajetConcerne(null);
        }

        // set the owning side of the relation if necessary
        if ($notifAnnulation !== null && $notifAnnulation->getTrajetConcerne() !== $this) {
            $notifAnnulation->setTrajetConcerne($this);
        }

        $this->notifAnnulation = $notifAnnulation;

        return $this;
    }

    public function getGroupeAmi(): ?GroupeAmis
    {
        return $this->groupeAmi;
    }

    public function setGroupeAmi(?GroupeAmis $groupeAmi): self
    {
        $this->groupeAmi = $groupeAmi;

        return $this;
    }


}
