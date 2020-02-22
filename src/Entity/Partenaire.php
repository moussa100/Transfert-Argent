<?php

namespace App\Entity;

use App\Entity\Compte;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PartenaireRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PartenaireRepository")
 */
class Partenaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ninea;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $registre_commerce;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $compte;

    /** 
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="partenaire")
     */
    private $userComptePartenaire;

    /** 
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="partenairesCreer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userCreateur;

    /** 
     * @ORM\OneToOne(targetEntity="App\Entity\Contrat", mappedBy="partenaire", cascade={"persist", "remove"})
     */
    private $contrat;

    public function __construct()
    {
        $this->compte = new ArrayCollection();
        $this->userComptePartenaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNinea(): ?string
    {
        return $this->ninea;
    }

    public function setNinea(string $ninea): self
    {
        $this->ninea = $ninea;

        return $this;
    }

    public function getRegistreCommerce(): ?string
    {
        return $this->registre_commerce;
    }

    public function setRegistreCommerce(string $registre_commerce): self
    {
        $this->registre_commerce = $registre_commerce;

        return $this;
    }

    /**
     * @return Collection|Compte[]
     */
    public function getCompte(): Collection
    {
        return $this->compte;
    }

    public function addCompte(Compte $compte): self
    {
        if (!$this->compte->contains($compte)) {
            $this->compte[] = $compte;
            $compte->setPartenaire($this);
        }

        return $this;
    }

    public function removeCompte(Compte $compte): self
    {
        if ($this->compte->contains($compte)) {
            $this->compte->removeElement($compte);
            // set the owning side to null (unless already changed)
            if ($compte->getPartenaire() === $this) {
                $compte->setPartenaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserComptePartenaire(): Collection
    {
        return $this->userComptePartenaire;
    }

    public function addUserComptepartenaire(User $userComptePartenaire): self
    {
        if (!$this->userComptePartenaire->contains($userComptePartenaire)) 
        {
            $this->userComptePartenaire[] = $userComptePartenaire;
            $userComptePartenaire->setPartenaire($this);
        }

        return $this;
    }
    
    public function removeUserComptePartenaire(User $userComptePartenaire): self
    {
        if ($this->userComptePartenaire->contains($userComptePartenaire))
        {
            $this->userComptePartenaire->removeElement($userComptePartenaire);
            // set the owning side to null (unless already changed)
            if ($userComptePartenaire->getPartenaire() === $this) 
            {
                $userComptePartenaire->setPartenaire(null);
            }
        }

        return $this;
    }

    public function getUserCreateur(): ?User
    {
        return $this->userCreateur;
    }

    public function setUserCreateur(?User $userCreateur): self
    {
        $this->userCreateur = $userCreateur;

        return $this;
    }

    public function getContrat(): ?Contrat
    {
        return $this->contrat;
    }

    public function setContrat(Contrat $contrat): self
    {
        $this->contrat = $contrat;

        // set the owning side of the relation if necessary
        if ($contrat->getPartenaire() !== $this) 
        {
            $contrat->setPartenaire($this);
        }

        return $this;
    }
}