<?php

namespace App\Entity\Bourse;

use App\Repository\Bourse\QuoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuoteRepository::class)
 */
class Quote
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Stock::class, inversedBy="quotes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $stock;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    private $currentPrice;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    private $openPrice;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    private $highPrice;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    private $lowPrice;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     */
    private $previousClosePrice;

    /**
     * @ORM\Column(type="datetime")
     */
    private $priceAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStock(): ?Stock
    {
        return $this->stock;
    }

    public function setStock(?Stock $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getCurrentPrice(): ?string
    {
        return $this->currentPrice;
    }

    public function setCurrentPrice(string $currentPrice): self
    {
        $this->currentPrice = $currentPrice;

        return $this;
    }

    public function getOpenPrice(): ?string
    {
        return $this->openPrice;
    }

    public function setOpenPrice(string $openPrice): self
    {
        $this->openPrice = $openPrice;

        return $this;
    }

    public function getHighPrice(): ?string
    {
        return $this->highPrice;
    }

    public function setHighPrice(string $highPrice): self
    {
        $this->highPrice = $highPrice;

        return $this;
    }

    public function getLowPrice(): ?string
    {
        return $this->lowPrice;
    }

    public function setLowPrice(string $lowPrice): self
    {
        $this->lowPrice = $lowPrice;

        return $this;
    }

    public function getPreviousClosePrice(): ?string
    {
        return $this->previousClosePrice;
    }

    public function setPreviousClosePrice(string $previousClosePrice): self
    {
        $this->previousClosePrice = $previousClosePrice;

        return $this;
    }

    public function getPriceAt(): ?\DateTimeInterface
    {
        return $this->priceAt;
    }

    public function setPriceAt(\DateTimeInterface $priceAt): self
    {
        $this->priceAt = $priceAt;

        return $this;
    }

    /**
     * Renvoie le pourcentage de hausse / baisse
     * entre le prix actuel et la cloture de la veille
     * @return float
     */
    public function getPreviousPercent(): float
    {
        return round(($this->getCurrentPrice() - $this->getPreviousClosePrice()) / $this->getPreviousClosePrice() * 100, 2);
    }
}
