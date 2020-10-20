<?php

namespace App\Entity\Immo;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Immo\ProjetRepository")
 */
class Projet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */
    private $prixNetVendeur;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $fraisAgence;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $frais_notaire;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $travaux;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $meubles;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $apport;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $creditFraisDossier;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $creditGarantie;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $creditTaux;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $creditTauxAssurance;

    /**
     * @ORM\Column(type="smallint")
     */
    private $creditDureeMois;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creditDateDebut;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $loyerCibleHc;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $taxeFonciere;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $chargeNonRecuperable;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $coutAssuranceBien;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $coutTravauxEntretien;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $coutComptable;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $coutGestionLocative;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $coutAutre;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creeLe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Immo\Bien")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bien;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->creeLe = new \DateTime();
    }

    public function getPrixNetVendeur(): ?string
    {
        return $this->prixNetVendeur;
    }

    public function setPrixNetVendeur(string $prixNetVendeur): self
    {
        $this->prixNetVendeur = $prixNetVendeur;

        return $this;
    }

    public function getFraisAgence(): ?string
    {
        return $this->fraisAgence;
    }

    public function setFraisAgence(string $fraisAgence): self
    {
        $this->fraisAgence = $fraisAgence;

        return $this;
    }

    public function getFraisNotaire(): ?string
    {
        return $this->frais_notaire;
    }

    public function setFraisNotaire(string $frais_notaire): self
    {
        $this->frais_notaire = $frais_notaire;

        return $this;
    }

    public function getTravaux(): ?string
    {
        return $this->travaux;
    }

    public function setTravaux(string $travaux): self
    {
        $this->travaux = $travaux;

        return $this;
    }

    public function getMeubles(): ?string
    {
        return $this->meubles;
    }

    public function setMeubles(string $meubles): self
    {
        $this->meubles = $meubles;

        return $this;
    }

    public function getApport(): ?string
    {
        return $this->apport;
    }

    public function setApport(string $apport): self
    {
        $this->apport = $apport;

        return $this;
    }

    public function getCreditFraisDossier(): ?float
    {
        return $this->creditFraisDossier;
    }

    public function setCreditFraisDossier(float $creditFraisDossier): self
    {
        $this->creditFraisDossier = $creditFraisDossier;

        return $this;
    }

    public function getCreditGarantie(): ?float
    {
        return $this->creditGarantie;
    }

    public function setCreditGarantie(float $creditGarantie): self
    {
        $this->creditGarantie = $creditGarantie;

        return $this;
    }

    public function getCreditTaux(): ?float
    {
        return $this->creditTaux;
    }

    public function setCreditTaux(float $creditTaux): self
    {
        $this->creditTaux = $creditTaux;

        return $this;
    }

    public function getCreditTauxAssurance(): ?float
    {
        return $this->creditTauxAssurance;
    }

    public function setCreditTauxAssurance(float $creditTauxAssurance): self
    {
        $this->creditTauxAssurance = $creditTauxAssurance;

        return $this;
    }

    public function getCreditDureeMois(): ?int
    {
        return $this->creditDureeMois;
    }

    public function setCreditDureeMois(int $creditDureeMois): self
    {
        $this->creditDureeMois = $creditDureeMois;

        return $this;
    }

    public function getCreditDateDebut(): ?\DateTimeInterface
    {
        return $this->creditDateDebut;
    }

    public function setCreditDateDebut(\DateTimeInterface $creditDateDebut): self
    {
        $this->creditDateDebut = $creditDateDebut;

        return $this;
    }

    public function getCreditMontant(): ?int // TODO voir ce qu'on prend en compte dans le prêt
    {
        return $this->prixNetVendeur
            + $this->fraisAgence
            + $this->frais_notaire
            + $this->creditGarantie
            + $this->creditFraisDossier;
    }

    public function getLoyerCibleHc(): ?string
    {
        return $this->loyerCibleHc;
    }

    public function setLoyerCibleHc(string $loyerCibleHc): self
    {
        $this->loyerCibleHc = $loyerCibleHc;

        return $this;
    }

    public function getTaxeFonciere(): ?string
    {
        return $this->taxeFonciere;
    }

    public function setTaxeFonciere(string $taxeFonciere): self
    {
        $this->taxeFonciere = $taxeFonciere;

        return $this;
    }

    public function getChargeNonRecuperable(): ?string
    {
        return $this->chargeNonRecuperable;
    }

    public function setChargeNonRecuperable(string $chargeNonRecuperable): self
    {
        $this->chargeNonRecuperable = $chargeNonRecuperable;

        return $this;
    }

    public function getCoutAssuranceBien(): ?string
    {
        return $this->coutAssuranceBien;
    }

    public function setCoutAssuranceBien(string $coutAssuranceBien): self
    {
        $this->coutAssuranceBien = $coutAssuranceBien;

        return $this;
    }

    public function getCoutTravauxEntretien(): ?string
    {
        return $this->coutTravauxEntretien;
    }

    public function setCoutTravauxEntretien(string $coutTravauxEntretien): self
    {
        $this->coutTravauxEntretien = $coutTravauxEntretien;

        return $this;
    }

    public function getCoutComptable(): ?string
    {
        return $this->coutComptable;
    }

    public function setCoutComptable(string $coutComptable): self
    {
        $this->coutComptable = $coutComptable;

        return $this;
    }

    public function getCoutGestionLocative(): ?string
    {
        return $this->coutGestionLocative;
    }

    public function setCoutGestionLocative(string $coutGestionLocative): self
    {
        $this->coutGestionLocative = $coutGestionLocative;

        return $this;
    }

    public function getCoutAutre(): ?string
    {
        return $this->coutAutre;
    }

    public function setCoutAutre(string $coutAutre): self
    {
        $this->coutAutre = $coutAutre;

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

    public function getBien(): ?Bien
    {
        return $this->bien;
    }

    public function setBien(?Bien $bien): self
    {
        $this->bien = $bien;

        return $this;
    }
}
