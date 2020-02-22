<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Security\Voter\CompteVoter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\CompteRepository")
 * denormalizationContext={"groups"={"post"}},
 * collectionOperations={"get"={"normalization_context"={"groups"={"get"}},},
 * "post"={"security"="is_granted(['ROLE_ADMIN_SYSTEM','ROLE_ADMIN'])", 
 * "security_message"="Seul ADMIN_SYSTEM peut creer un user","controller"=CompteVoter::class ,}},
 * itemOperations={"get"={"security"="is_granted('ROLE_ADMIN_SYSTEM')"},
 * "put"={"security"="is_granted(['ROLE_ADMIN_SYSTEM','ROLE_ADMIN'])",
 * "security_message"="Seul ADMIN_SYST peut bloquer un user"}} )
 */
 
class Compte
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $numero_compte;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="integer")
     */
    private $solde;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="compte")
     */
    private $depot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="compte")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="compte")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partenaire;

    /** 
     * @ORM\Column(type="string", length=255)   
     */
    private $statut;

    public function __construct()
    {
        $this->statut = "actif";
        $this->depot = new ArrayCollection();
        $this->user = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numero_compte;
    }

    public function setNumeroCompte(string $numero_compte): self
    {
        $this->numero_compte = $numero_compte;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getSolde(): ?string
    {
        return $this->solde;
    }

    public function setSolde(string $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    /**
     * @return Collection|Depot[]
     */
    public function getDepot(): Collection
    {
        return $this->depot;
    }

    public function addDepot(Depot $depot): self
    {
        if (!$this->depot->contains($depot)) {
            $this->depot[] = $depot;
            $depot->setCompte($this);
        }

        return $this;
    }

    public function removeDepot(Depot $depot): self
    {
        if ($this->depot->contains($depot)) {
            $this->depot->removeElement($depot);
            // set the owning side to null (unless already changed)
            if ($depot->getCompte() === $this) 
            {
                $depot->setCompte(null);
            }
        }

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }

    public function setPartenaire(?Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;

        return $this;
    }

}
