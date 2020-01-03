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
    private $net_vendeur;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $frais_agence;

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
    private $credit_frais_dossier;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $credit_garantie;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $credit_taux;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $credit_taux_ass;

    /**
     * @ORM\Column(type="smallint")
     */
    private $credit_duree_mois;

    /**
     * @ORM\Column(type="datetime")
     */
    private $credit_date_debut;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $loyer_cible_hc;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $taxe_fonciere;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $charges_non_recup;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $cout_assurance_bien;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $cout_travaux_entretiens;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $cout_comptable;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $cout_gestion_locative;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $cout_autre;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

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
        $this->created_at = new \DateTime();
    }

    public function getNetVendeur(): ?string
    {
        return $this->net_vendeur;
    }

    public function setNetVendeur(string $net_vendeur): self
    {
        $this->net_vendeur = $net_vendeur;

        return $this;
    }

    public function getFraisAgence(): ?string
    {
        return $this->frais_agence;
    }

    public function setFraisAgence(string $frais_agence): self
    {
        $this->frais_agence = $frais_agence;

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
        return $this->credit_frais_dossier;
    }

    public function setCreditFraisDossier(float $credit_frais_dossier): self
    {
        $this->credit_frais_dossier = $credit_frais_dossier;

        return $this;
    }

    public function getCreditGarantie(): ?float
    {
        return $this->credit_garantie;
    }

    public function setCreditGarantie(float $credit_garantie): self
    {
        $this->credit_garantie = $credit_garantie;

        return $this;
    }

    public function getCreditTaux(): ?float
    {
        return $this->credit_taux;
    }

    public function setCreditTaux(float $credit_taux): self
    {
        $this->credit_taux = $credit_taux;

        return $this;
    }

    public function getCreditTauxAss(): ?float
    {
        return $this->credit_taux_ass;
    }

    public function setCreditTauxAss(float $credit_taux_ass): self
    {
        $this->credit_taux_ass = $credit_taux_ass;

        return $this;
    }

    public function getCreditDureeMois(): ?int
    {
        return $this->credit_duree_mois;
    }

    public function setCreditDureeMois(int $credit_duree_mois): self
    {
        $this->credit_duree_mois = $credit_duree_mois;

        return $this;
    }

    public function getCreditDateDebut(): ?\DateTimeInterface
    {
        return $this->credit_date_debut;
    }

    public function setCreditDateDebut(\DateTimeInterface $credit_date_debut): self
    {
        $this->credit_date_debut = $credit_date_debut;

        return $this;
    }

    public function getLoyerCibleHc(): ?string
    {
        return $this->loyer_cible_hc;
    }

    public function setLoyerCibleHc(string $loyer_cible_hc): self
    {
        $this->loyer_cible_hc = $loyer_cible_hc;

        return $this;
    }

    public function getTaxeFonciere(): ?string
    {
        return $this->taxe_fonciere;
    }

    public function setTaxeFonciere(string $taxe_fonciere): self
    {
        $this->taxe_fonciere = $taxe_fonciere;

        return $this;
    }

    public function getChargesNonRecup(): ?string
    {
        return $this->charges_non_recup;
    }

    public function setChargesNonRecup(string $charges_non_recup): self
    {
        $this->charges_non_recup = $charges_non_recup;

        return $this;
    }

    public function getCoutAssuranceBien(): ?string
    {
        return $this->cout_assurance_bien;
    }

    public function setCoutAssuranceBien(string $cout_assurance_bien): self
    {
        $this->cout_assurance_bien = $cout_assurance_bien;

        return $this;
    }

    public function getCoutTravauxEntretiens(): ?string
    {
        return $this->cout_travaux_entretiens;
    }

    public function setCoutTravauxEntretiens(string $cout_travaux_entretiens): self
    {
        $this->cout_travaux_entretiens = $cout_travaux_entretiens;

        return $this;
    }

    public function getCoutComptable(): ?string
    {
        return $this->cout_comptable;
    }

    public function setCoutComptable(string $cout_comptable): self
    {
        $this->cout_comptable = $cout_comptable;

        return $this;
    }

    public function getCoutGestionLocative(): ?string
    {
        return $this->cout_gestion_locative;
    }

    public function setCoutGestionLocative(string $cout_gestion_locative): self
    {
        $this->cout_gestion_locative = $cout_gestion_locative;

        return $this;
    }

    public function getCoutAutre(): ?string
    {
        return $this->cout_autre;
    }

    public function setCoutAutre(string $cout_autre): self
    {
        $this->cout_autre = $cout_autre;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

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
