<?php

namespace App\Entity\Bourse;

use App\Repository\Bourse\ActionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=ActionRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Action // == stock
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=12, unique=true)
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
    private $capitalisation; // Market cap

    /**
     * @ORM\Column(type="integer")
     */
    private $actionsEnCirculation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $webUrl;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $tel;

    /**
     * @ORM\OneToMany(targetEntity=Cote::class, mappedBy="action")
     */
    private $cotes;

    /**
     * @ORM\OneToMany(targetEntity=Ordre::class, mappedBy="action")
     */
    private $ordres;

    /**
     * @ORM\OneToMany(targetEntity=Alerte::class, mappedBy="action")
     */
    private $alertes;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creeLe;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $majLe;

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist()
     */
    public function onPrePersist()
    {
        $this->creeLe = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate()
     */
    public function onPreUpdate()
    {
        $this->majLe = new \DateTime("now");
    }

    public function __construct()
    {
        $this->cotes  = new ArrayCollection();
        $this->ordres = new ArrayCollection();
        $this->alertes = new ArrayCollection();
    } // == symbol

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getCapitalisation(): ?string
    {
        return $this->capitalisation;
    }

    public function setCapitalisation(string $capitalisation): self
    {
        $this->capitalisation = $capitalisation;

        return $this;
    }

    public function getActionsEnCirculation(): ?int
    {
        return $this->actionsEnCirculation;
    }

    public function setActionsEnCirculation(int $actionsEnCirculation): self
    {
        $this->actionsEnCirculation = $actionsEnCirculation;

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
     * @return Collection|Cote[]
     */
    public function getCotes(): Collection
    {
        return $this->cotes;
    }

    public function addCote(Cote $cote): self
    {
        if (!$this->cotes->contains($cote)) {
            $this->cotes[] = $cote;
            $cote->setAction($this);
        }

        return $this;
    }

    public function removeCote(Cote $cote): self
    {
        if ($this->cotes->contains($cote)) {
            $this->cotes->removeElement($cote);
            // set the owning side to null (unless already changed)
            if ($cote->getAction() === $this) {
                $cote->setAction(null);
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
     * @return Collection|Ordre[]
     */
    public function getOrdres(): Collection
    {
        return $this->ordres;
    }

    public function addOrder(Ordre $order): self
    {
        if (!$this->ordres->contains($order)) {
            $this->ordres[] = $order;
            $order->setAction($this);
        }

        return $this;
    }

    public function removeOrder(Ordre $order): self
    {
        if ($this->ordres->contains($order)) {
            $this->ordres->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getAction() === $this) {
                $order->setAction(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Alerte[]
     */
    public function getAlertes(): Collection
    {
        return $this->alertes;
    }

    public function addAlerte(Alerte $alerte): self
    {
        if (!$this->alertes->contains($alerte)) {
            $this->alertes[] = $alerte;
            $alerte->setAction($this);
        }

        return $this;
    }

    public function removeAlerte(Alerte $alerte): self
    {
        if ($this->alertes->removeElement($alerte)) {
            // set the owning side to null (unless already changed)
            if ($alerte->getAction() === $this) {
                $alerte->setAction(null);
            }
        }

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

    public function getMajLe(): ?\DateTimeInterface
    {
        return $this->majLe;
    }

    public function setMajLe(?\DateTimeInterface $majLe): self
    {
        $this->majLe = $majLe;

        return $this;
    }
}
