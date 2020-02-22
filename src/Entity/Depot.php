<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(
 * collectionOperations={
 *"post"={"access_control"="is_granted('POST', object)"}
 * },
 * )
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
     * @ORM\Column(type="datatime")
     */
    private $date_depot;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $montant_depot;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compte", inversedBy="depot")
     * @ORM\JoinColumn(nullable=false)
     */
    private $compte;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="depot")
     * @ORM\JoinColumn(nullable=false)
     */
    private $caissierAdd;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDepot(): ?\DateTimeInterface
    {
        return $this->date_depot;
    }

    public function setDateDepot(\DateTimeInterface $date_depot): self
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

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    public function getCaissierAdd(): ?User
    {
        return $this->caissierAdd;
    }

    public function setCaissierAdd(?User $caissierAdd): self
    {
        $this->caissierAdd = $caissierAdd;

        return $this;
    }
}
