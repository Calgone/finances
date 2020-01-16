<?php

namespace App\Entity\Compta;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Compta\OperationRepository")
 */
class Operation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_operation;

    /**
     * @ORM\Column(type="smallint")
     */
    private $type_operation;

    /**
     * @ORM\Column(type="smallint")
     */
    private $mode_paiement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */
    private $montant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateOperation(): ?\DateTimeInterface
    {
        return $this->date_operation;
    }

    public function setDateOperation(\DateTimeInterface $date_operation): self
    {
        $this->date_operation = $date_operation;

        return $this;
    }

    public function getTypeOperation(): ?int
    {
        return $this->type_operation;
    }

    public function setTypeOperation(int $type_operation): self
    {
        $this->type_operation = $type_operation;

        return $this;
    }

    public function getModePaiement(): ?int
    {
        return $this->mode_paiement;
    }

    public function setModePaiement(int $mode_paiement): self
    {
        $this->mode_paiement = $mode_paiement;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }
}
