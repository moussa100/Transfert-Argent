<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\DepotRepository")
 */
class Depot
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
    private $date_depot;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $montant_depot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="depot")
     */
    private $no;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="depot")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDepot(): ?string
    {
        return $this->date_depot;
    }

    public function setDateDepot(string $date_depot): self
    {
        $this->date_depot = $date_depot;

        return $this;
    }

    public function getMontantDepot(): ?string
    {
        return $this->montant_depot;
    }

    public function setMontantDepot(string $montant_depot): self
    {
        $this->montant_depot = $montant_depot;

        return $this;
    }

    public function getNo(): ?Compte
    {
        return $this->no;
    }

    public function setNo(?Compte $no): self
    {
        $this->no = $no;

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
}
