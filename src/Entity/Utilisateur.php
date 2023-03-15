<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[UniqueEntity('adresseMail')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface, EquatableInterface
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 320, unique: true)]
    private ?string $adresseMail = null;


    #[ORM\Column(length: 128)]
    private ?string $mdp = null;

    #[ORM\Column(length: 64)]
    private ?string $nom = null;

    #[ORM\Column(length: 64)]
    private ?string $prenom = null;

    #[ORM\Column(length: 1)]
    private ?string $sexe = null;

    #[ORM\Column]
    private ?bool $voiture = null;

    #[ORM\Column(length: 11)]
    private ?string $noTel = null;

    #[ORM\Column]
    private ?bool $mailNotif = null;

    #[ORM\ManyToMany(targetEntity: Trajet::class, mappedBy: 'utilisateurs')]
    private Collection $trajets;

    #[ORM\ManyToMany(targetEntity: GroupeAmis::class, inversedBy: 'utilisateurs')]
    #[ORM\JoinTable(name: 'amitie')]
    private Collection $Amis;

    #[ORM\OneToMany(mappedBy: 'Covoitureur', targetEntity: Trajet::class, cascade:['persist'])]
    private Collection $trajetProposes;

    #[ORM\OneToMany(mappedBy: 'utilisateurConcerne', targetEntity: Reponse::class)]
    private Collection $reponses;

    #[ORM\OneToMany(mappedBy: 'UtilisateurConcerne', targetEntity: NotifReponse::class)]
    private Collection $notifreponses;

    #[ORM\OneToMany(mappedBy: 'UtilisateurConcerne', targetEntity: NotifTrajetPrive::class)]
    private Collection $notifTrajetsPrives;

    #[ORM\OneToMany(mappedBy: 'UtilisateurConcerne', targetEntity: NotifAnnulation::class)]
    private Collection $notifAnnulations;

    public function __construct()
    {
        $this->trajets = new ArrayCollection();
        $this->Amis = new ArrayCollection();
        $this->trajetProposes = new ArrayCollection();
        $this->reponses = new ArrayCollection();
        $this->notifreponses = new ArrayCollection();
        $this->notifTrajetsPrives = new ArrayCollection();
        $this->notifAnnulations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresseMail(): ?string
    {
        return $this->adresseMail;
    }

    public function setAdresseMail(string $adresseMail): self
    {
        $this->adresseMail = $adresseMail;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function isVoiture(): ?bool
    {
        return $this->voiture;
    }

    public function setVoiture(bool $voiture): self
    {
        $this->voiture = $voiture;

        return $this;
    }

    public function getNoTel(): ?string
    {
        return $this->noTel;
    }

    public function setNoTel(string $noTel): self
    {
        $this->noTel = $noTel;

        return $this;
    }

    public function isMailNotif(): ?bool
    {
        return $this->mailNotif;
    }

    public function setMailNotif(bool $mailNotif): self
    {
        $this->mailNotif = $mailNotif;

        return $this;
    }

    /**
     * @return Collection<int, Trajet>
     */
    public function getTrajets(): Collection
    {
        return $this->trajets;
    }

    public function addTrajet(Trajet $trajet): self
    {
        if (!$this->trajets->contains($trajet)) {
            $this->trajets->add($trajet);
            $trajet->addUtilisateur($this);
        }

        return $this;
    }

    public function removeTrajet(Trajet $trajet): self
    {
        if ($this->trajets->removeElement($trajet)) {
            $trajet->removeUtilisateur($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, GroupeAmis>
     */
    public function getAmis(): Collection
    {
        return $this->Amis;
    }

    public function addAmi(GroupeAmis $ami): self
    {
        if (!$this->Amis->contains($ami)) {
            $this->Amis->add($ami);
        }

        return $this;
    }

    public function removeAmi(GroupeAmis $ami): self
    {
        $this->Amis->removeElement($ami);

        return $this;
    }

    /**
     * @return Collection<int, Trajet>
     */
    public function getTrajetProposes(): Collection
    {
        return $this->trajetProposes;
    }

    public function addTrajetPropose(Trajet $trajetPropose): self
    {
        if (!$this->trajetProposes->contains($trajetPropose)) {
            $this->trajetProposes->add($trajetPropose);
            $trajetPropose->setCovoitureur($this);
            $this->addTrajet($trajetPropose);
        }

        return $this;
    }

    public function removeTrajetPropose(Trajet $trajetPropose): self
    {
        if ($this->trajetProposes->removeElement($trajetPropose)) {
            // set the owning side to null (unless already changed)
            if ($trajetPropose->getCovoitureur() === $this) {
                $trajetPropose->setCovoitureur(null);
            }
        }

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
            $reponse->setUtilisateurConcerne($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getUtilisateurConcerne() === $this) {
                $reponse->setUtilisateurConcerne(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NotifReponse>
     */
    public function getNotifreponses(): Collection
    {
        return $this->notifreponses;
    }

    public function addNotifreponse(NotifReponse $notifreponse): self
    {
        if (!$this->notifreponses->contains($notifreponse)) {
            $this->notifreponses->add($notifreponse);
            $notifreponse->setUtilisateurConcerne($this);
        }

        return $this;
    }

    public function removeNotifreponse(NotifReponse $notifreponse): self
    {
        if ($this->notifreponses->removeElement($notifreponse)) {
            // set the owning side to null (unless already changed)
            if ($notifreponse->getUtilisateurConcerne() === $this) {
                $notifreponse->setUtilisateurConcerne(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NotifTrajetPrive>
     */
    public function getNotifTrajetsPrives(): Collection
    {
        return $this->notifTrajetsPrives;
    }

    public function addNotifTrajetsPrife(NotifTrajetPrive $notifTrajetsPrife): self
    {
        if (!$this->notifTrajetsPrives->contains($notifTrajetsPrife)) {
            $this->notifTrajetsPrives->add($notifTrajetsPrife);
            $notifTrajetsPrife->setUtilisateurConcerne($this);
        }

        return $this;
    }

    public function removeNotifTrajetsPrife(NotifTrajetPrive $notifTrajetsPrife): self
    {
        if ($this->notifTrajetsPrives->removeElement($notifTrajetsPrife)) {
            // set the owning side to null (unless already changed)
            if ($notifTrajetsPrife->getUtilisateurConcerne() === $this) {
                $notifTrajetsPrife->setUtilisateurConcerne(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NotifAnnulation>
     */
    public function getNotifAnnulations(): Collection
    {
        return $this->notifAnnulations;
    }

    public function addNotifAnnulation(NotifAnnulation $notifAnnulation): self
    {
        if (!$this->notifAnnulations->contains($notifAnnulation)) {
            $this->notifAnnulations->add($notifAnnulation);
            $notifAnnulation->setUtilisateurConcerne($this);
        }

        return $this;
    }

    public function removeNotifAnnulation(NotifAnnulation $notifAnnulation): self
    {
        if ($this->notifAnnulations->removeElement($notifAnnulation)) {
            // set the owning side to null (unless already changed)
            if ($notifAnnulation->getUtilisateurConcerne() === $this) {
                $notifAnnulation->setUtilisateurConcerne(null);
            }
        }

        return $this;
    }


    public function getUserIdentifier(){
        return $this->getAdresseMail();
    }


    public function getPassword(): ?string
    {
        return $this->getMdp();
    }


    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials()
    {
        $this->mdp = null;
    }

    public function getUsername(): ?string
    {
        return $this->getAdresseMail();
    }


    public function getRoles()
    {
        //$roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public
    function isEqualTo(UserInterface $user): bool
    {
        {
            if (!$user instanceof Utilisateur) {
                return true;
            }

            if ($this->mdp !== $user->getPassword()) {
                return true;
            }


            if ($this->adresseMail !== $user->getUsername()) {
                return false;
            }

            return true;
        }
    }

}
