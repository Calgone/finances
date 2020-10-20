<?php

namespace App\Entity\Banque;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Compta\CompteRepository")
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
     * @ORM\Column(type="string", length=255)
     */
    private $numero;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creeLe;

    /**
     * @ORM\Column(type="date")
     */
    private $ouvertLe;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fermeLe;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    private $solde; // balance

    /**
     * @ORM\ManyToOne(targetEntity=Banque::class, inversedBy="comptes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $banque;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getCreeLe(): ?\DateTimeInterface
    {
        return $this->creeLe;
    }

    public function setCreeLe(\DateTimeInterface $creeLe): self
    {
        $this->creeLe = $creeLe;

        return $this;
    }

    public function getOuvertLe(): ?\DateTimeInterface
    {
        return $this->ouvertLe;
    }

    public function setOuvertLe(\DateTimeInterface $ouvertLe): self
    {
        $this->ouvertLe = $ouvertLe;

        return $this;
    }

    public function getFermeLe(): ?\DateTimeInterface
    {
        return $this->fermeLe;
    }

    public function setFermeLe(?\DateTimeInterface $fermeLe): self
    {
        $this->fermeLe = $fermeLe;

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

    public function getBanque(): ?Banque
    {
        return $this->banque;
    }

    public function setBanque(?Banque $banque): self
    {
        $this->banque = $banque;

        return $this;
    }
}
