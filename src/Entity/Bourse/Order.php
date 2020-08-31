<?php

namespace App\Entity\Bourse;

use App\Repository\Bourse\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $isin;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $direction; // buy or sell

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $state; //

    /**
     * @ORM\Column(type="integer")
     */
    private $volume; // quantité

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="float")
     */
    private $quotation; // cours

    /**
     * @ORM\Column(type="date")
     */
    private $validity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $exchange;

    /**
     * @ORM\Column(type="float")
     */
    private $brokerFee;

    /**
     * @ORM\ManyToOne(targetEntity=Stock::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $stock; // Frais de courtage

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getIsin(): ?string
    {
        return $this->isin;
    }

    public function setIsin(string $isin): self
    {
        $this->isin = $isin;

        return $this;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function setDirection(string $direction): self
    {
        $this->direction = $direction;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getVolume(): ?int
    {
        return $this->volume;
    }

    public function setVolume(int $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getQuotation(): ?float
    {
        return $this->quotation;
    }

    public function setQuotation(float $quotation): self
    {
        $this->quotation = $quotation;

        return $this;
    }

    public function getValidity(): ?\DateTimeInterface
    {
        return $this->validity;
    }

    public function setValidity(\DateTimeInterface $validity): self
    {
        $this->validity = $validity;

        return $this;
    }

    public function getExchange(): ?string
    {
        return $this->exchange;
    }

    public function setExchange(string $exchange): self
    {
        $this->exchange = $exchange;

        return $this;
    }

    public function getBrokerfee(): ?float
    {
        return $this->brokerFee;
    }

    public function setBrokerfee(float $brokerFee): self
    {
        $this->brokerFee = $brokerFee;

        return $this;
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
}
