<?php

namespace App\Entity\Bourse;

use App\Repository\Bourse\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`ordre`")
 */
class Ordre
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

    // buy or sell

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $etat; //

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite; // volume

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="float")
     */
    private $cours; // quotation

    /**
     * @ORM\Column(type="date")
     */
    private $validite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marche;

    /**
     * @ORM\Column(type="float")
     */
    private $fraisCourtage;

    /**
     * @ORM\ManyToOne(targetEntity=Action::class, inversedBy="ordres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $action;

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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

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

    public function getCours(): ?float
    {
        return $this->cours;
    }

    public function setCours(float $cours): self
    {
        $this->cours = $cours;

        return $this;
    }

    public function getValidite(): ?\DateTimeInterface
    {
        return $this->validite;
    }

    public function setValidite(\DateTimeInterface $validite): self
    {
        $this->validite = $validite;

        return $this;
    }

    public function getMarche(): ?string
    {
        return $this->marche;
    }

    public function setMarche(string $marche): self
    {
        $this->marche = $marche;

        return $this;
    }

    public function getFraisCourtage(): ?float
    {
        return $this->fraisCourtage;
    }

    public function setFraisCourtage(float $fraisCourtage): self
    {
        $this->fraisCourtage = $fraisCourtage;

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
    public function getDirectionLetterHtml()
    {
        if ($this->type === 'a') { // achat
            $color = 'green';
            $letter = 'A';
        } else {
            $color = 'red';
            $letter = 'V';
        }
        return '<span style="color:'.$color.'">' . $letter . '</span>';
    }
}
