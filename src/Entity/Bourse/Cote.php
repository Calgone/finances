<?php

namespace App\Entity\Bourse;

use App\Repository\Bourse\QuoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuoteRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Cote
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Action::class, inversedBy="cotes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $action;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    private $prix;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    private $prixOuverture;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    private $prixMax;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    private $prixMin;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    private $prixClotureVeille;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creeLe;

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist()
     */
    public function onPrePersist()
    {
        $this->creeLe = new \DateTime("now");
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPrixOuverture(): ?string
    {
        return $this->prixOuverture;
    }

    public function setPrixOuverture(string $prixOuverture): self
    {
        $this->prixOuverture = $prixOuverture;

        return $this;
    }

    public function getPrixMax(): ?string
    {
        return $this->prixMax;
    }

    public function setPrixMax(string $prixMax): self
    {
        $this->prixMax = $prixMax;

        return $this;
    }

    public function getPrixMin(): ?string
    {
        return $this->prixMin;
    }

    public function setPrixMin(string $prixMin): self
    {
        $this->prixMin = $prixMin;

        return $this;
    }

    public function getPrixClotureVeille(): ?string
    {
        return $this->prixClotureVeille;
    }

    public function setPrixClotureVeille(string $prixClotureVeille): self
    {
        $this->prixClotureVeille = $prixClotureVeille;

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

    /**
     * Renvoie le pourcentage de hausse / baisse
     * entre le prix actuel et la cloture de la veille
     * @return float
     */
    public function getPreviousPercent(): float
    {
        return round(($this->getPrix() - $this->getPrixClotureVeille()) / $this->getPrixClotureVeille() * 100, 2);
    }
}
