<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * @ApiResource(
 * collectionOperations={
 * "post"={"access_control"="is_granted('POST', object)"}
 * },
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements AdvancedUserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Profil", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $profil;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Depot", mappedBy="user")
     */
    private $depot;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Partenaire", cascade={"persist", "remove"})
     */
    private $partenaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Compte", mappedBy="user")
     */
    private $compte;

    public function __construct()
    {
        $this->depot = new ArrayCollection();
        $this->compte = new ArrayCollection();
        $this->isActive= true;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles[] = $this->profil->getLibelle();
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }


    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function isAccountNonExpired(){
        return true;
    }
     public function isAccountNonLocked(){
         return true;
     }
     public function isCredentialsNonExpired()
     {
         return true;
     }
     public function isEnabled(){
         return $this->isActive;
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
             $depot->setUser($this);
         }

         return $this;
     }

     public function removeDepot(Depot $depot): self
     {
         if ($this->depot->contains($depot)) {
             $this->depot->removeElement($depot);
             // set the owning side to null (unless already changed)
             if ($depot->getUser() === $this) {
                 $depot->setUser(null);
             }
         }

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
             $compte->setUser($this);
         }

         return $this;
     }

     public function removeCompte(Compte $compte): self
     {
         if ($this->compte->contains($compte)) {
             $this->compte->removeElement($compte);
             // set the owning side to null (unless already changed)
             if ($compte->getUser() === $this) {
                 $compte->setUser(null);
             }
         }

         return $this;
     }
}
