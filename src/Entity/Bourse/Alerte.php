<?php

namespace App\Entity\Bourse;

use App\Repository\Bourse\AlertRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlertRepository::class)
 */
class Alerte
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creeLe;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     */
    private $date_fin;

    /**
     * @ORM\ManyToOne(targetEntity=AlerteModele::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $alerteModele;

    /**
     * @ORM\ManyToOne(targetEntity=Action::class, inversedBy="alertes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $action;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $methode;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $seuilBas;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $seuilHaut;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $referentiel;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $variation;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $intervalle;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getAlerteModele(): ?AlerteModele
    {
        return $this->alerteModele;
    }

    public function setAlerteModele(?AlerteModele $alerteModele): self
    {
        $this->alerteModele = $alerteModele;

        return $this;
    }

    public function getAction(): ?Action
    {
        return $this->action;
    }

    public function setAction(?Action $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getMethode(): ?string
    {
        return $this->methode;
    }

    public function setMethode(string $methode): self
    {
        $this->methode = $methode;

        return $this;
    }

    public function getSeuilBas(): ?string
    {
        return $this->seuilBas;
    }

    public function setSeuilBas(string $seuilBas): self
    {
        $this->seuilBas = $seuilBas;

        return $this;
    }

    public function getSeuilHaut(): ?string
    {
        return $this->seuilHaut;
    }

    public function setSeuilHaut(string $seuilHaut): self
    {
        $this->seuilHaut = $seuilHaut;

        return $this;
    }

    public function getReferentiel(): ?string
    {
        return $this->referentiel;
    }

    public function setReferentiel(?string $referentiel): self
    {
        $this->referentiel = $referentiel;

        return $this;
    }

    public function getFreqType(): ?string
    {
        return $this->freqType;
    }

    public function setFreqType(string $freqType): self
    {
        $this->freqType = $freqType;

        return $this;
    }

    public function getFreqVal(): ?int
    {
        return $this->freqVal;
    }

    public function setFreqVal(int $freqVal): self
    {
        $this->freqVal = $freqVal;

        return $this;
    }

    public function getVariation(): ?string
    {
        return $this->variation;
    }

    public function setVariation(?string $variation): self
    {
        $this->variation = $variation;

        return $this;
    }

    public function getIntervalle(): ?string
    {
        return $this->intervalle;
    }

    public function setIntervalle(string $intervalle): self
    {
        $this->intervalle = $intervalle;

        return $this;
    }

}
