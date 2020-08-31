<?php

namespace App\Entity\Bourse;

use App\Repository\Bourse\StockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StockRepository::class)
 */
class Stock // == stock
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
    private $name;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $isin;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $ticker;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="date")
     */
    private $ipo;

    /**
     * @ORM\Column(type="decimal", precision=18, scale=4)
     */
    private $marketCap;

    /**
     * @ORM\Column(type="integer")
     */
    private $shareOutstanding;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $webUrl;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $tel;

    /**
     * @ORM\OneToMany(targetEntity=Quote::class, mappedBy="stock")
     */
    private $quotes;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="stock")
     */
    private $orders;

    public function __construct()
    {
        $this->quotes = new ArrayCollection();
        $this->orders = new ArrayCollection();
    } // == symbol

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getTicker(): ?string
    {
        return $this->ticker;
    }

    public function setTicker(string $ticker): self
    {
        $this->ticker = $ticker;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getIpo(): ?\DateTimeInterface
    {
        return $this->ipo;
    }

    public function setIpo(\DateTimeInterface $ipo): self
    {
        $this->ipo = $ipo;

        return $this;
    }

    public function getMarketCap(): ?string
    {
        return $this->marketCap;
    }

    public function setMarketCap(string $marketCap): self
    {
        $this->marketCap = $marketCap;

        return $this;
    }

    public function getShareOutstanding(): ?int
    {
        return $this->shareOutstanding;
    }

    public function setShareOutstanding(int $shareOutstanding): self
    {
        $this->shareOutstanding = $shareOutstanding;

        return $this;
    }

    public function getWebUrl(): ?string
    {
        return $this->webUrl;
    }

    public function setWebUrl(?string $webUrl): self
    {
        $this->webUrl = $webUrl;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * @return Collection|Quote[]
     */
    public function getQuotes(): Collection
    {
        return $this->quotes;
    }

    public function addQuote(Quote $quote): self
    {
        if (!$this->quotes->contains($quote)) {
            $this->quotes[] = $quote;
            $quote->setStock($this);
        }

        return $this;
    }

    public function removeQuote(Quote $quote): self
    {
        if ($this->quotes->contains($quote)) {
            $this->quotes->removeElement($quote);
            // set the owning side to null (unless already changed)
            if ($quote->getStock() === $this) {
                $quote->setStock(null);
            }
        }

        return $this;
    }

    public function getLienBoursorama(): string
    {
        $ticker_court = explode('.', $this->ticker);
        return 'https://bour.so/c/1rP' . $ticker_court[0];
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setStock($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getStock() === $this) {
                $order->setStock(null);
            }
        }

        return $this;
    }
}
