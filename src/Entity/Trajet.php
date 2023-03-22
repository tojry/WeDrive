<?php

namespace App\Entity;
use App\Repository\TrajetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TrajetRepository::class)]
class Trajet
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\GreaterThan('+24 hours')]
    private ?\DateTimeInterface $dateHeureDepart = null;

    #[ORM\Column]
    #[Assert\Positive]
    private ?int $prix = null;

    #[ORM\Column]
    #[Assert\Positive]
    private ?int $capaciteMax = null;

    #[ORM\Column(length: 1024)]
    private ?string $precisionLieuRdv = null;

    #[ORM\Column(length: 1024, nullable:true)]
    private ?string $commentaire = null;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class, inversedBy: 'trajets')]
    #[ORM\JoinTable(name: 'participation')]
    #[ORM\JoinColumn(name: 'id_offre', referencedColumnName: "id")]
    #[ORM\InverseJoinColumn(name: 'id_utilisateur', referencedColumnName: "id")]
    private Collection $utilisateurs;

    #[ORM\OneToMany(mappedBy: 'trajet', targetEntity: PointIntermediaire::class, cascade:['persist'])]
    private Collection $PointIntermediaires;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class,inversedBy: 'trajetProposes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $Covoitureur = null;

    #[ORM\OneToMany(mappedBy: 'trajetConcerne', targetEntity: Reponse::class, cascade:['persist', 'remove'])]
    private Collection $reponses;

    #[ORM\OneToOne(mappedBy: 'trajetConcerne', cascade: ['persist', 'remove'])]
    private ?NotifTrajetPrive $notifTrajetPrive = null;

    #[ORM\OneToOne(mappedBy: 'trajetConcerne', cascade: ['persist', 'remove'])]
    private ?NotifAnnulation $notifAnnulation = null;

    #[ORM\ManyToOne(inversedBy: 'trajets', cascade:["persist"])]
    private ?GroupeAmis $groupeAmi = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ville $lieuDepart = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ville $lieuArrive = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\Positive]
    private $placesDispo;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
        $this->PointIntermediaires = new ArrayCollection();
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
        $this->placesDispo = $capaciteMax;

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
            $utilisateur->addTrajet($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        $this->utilisateurs->removeElement($utilisateur);

        return $this;
    }

    /**
     * @return Collection<int, PointIntermediaire>
     */
    public function getPointIntermediaires(): Collection
    {
        return $this->PointIntermediaires;
    }

    public function addPointIntermediaire(PointIntermediaire $PointIntermediaire): self
    {
        if (!$this->PointIntermediaires->contains($PointIntermediaire)) {
            $this->PointIntermediaires->add($PointIntermediaire);
            $PointIntermediaire->setTrajet($this);
        }

        return $this;
    }

    public function removePointIntermediaire(PointIntermediaire $PointIntermediaire): self
    {
        if ($this->PointIntermediaires->removeElement($PointIntermediaire)) {
            // set the owning side to null (unless already changed)
            if ($PointIntermediaire->getTrajet() === $this) {
                $PointIntermediaire->setTrajet(null);
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

    public function newArrayPointIntermediaires(): self
    {

        $this->PointIntermediaires = new ArrayCollection();

        return $this;
    }

    public function getLieuDepart(): ?Ville
    {
        return $this->lieuDepart;
    }

    public function setLieuDepart(?Ville $lieuDepart): self
    {
        $this->lieuDepart = $lieuDepart;

        return $this;
    }

    public function getLieuArrive(): ?Ville
    {
        return $this->lieuArrive;
    }

    public function setLieuArrive(?Ville $lieuArrive): self
    {
        $this->lieuArrive = $lieuArrive;

        return $this;
    }

    public function getPlacesDispo(): ?int
    {
        return $this->placesDispo;
    }

    public function setPlacesDispo(int $placesDispo): self
    {
        $this->placesDispo = $placesDispo;

        return $this;
    }

    public function diminuerPlacesDispo(): self
    {
        $this->placesDispo--;

        return $this;
    }

    public function augmenterPlacesDispo(): self
    {
        $this->placesDispo++;

        return $this;
    }


}
