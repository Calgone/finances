<?php

namespace App\Entity\Immo;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Immo\BienRepository")
 */
class Bien
{
    const TYPE = [
        1 => 'Immeuble',
        2 => 'Maison',
        3 => 'Appartement'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"list", "show"})
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     * @Groups({"show"})
     * @Assert\NotNull()
     */
    private $bienType;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show"})
     * @Assert\NotBlank()
     * @Assert\Length(min="2", minMessage="Ce champ doit contenir un minimum de {{ limit }} caractères", max="255", maxMessage="Ce champ doit contenir un maximum de {{ limit }} caractères")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=5)
     * @Groups({"list", "show"})
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=5)
     * @Assert\Regex("/^[0-9]{5}$/")
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"list", "show"})
     * @Assert\NotBlank()
     * @Assert\Length(min="2", minMessage="La action minimum autorisée est {{ limit }}",max="100", maxMessage="La action maximum autorisée est {{ limit }}")
     */
    private $ville;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"list", "show"})
     */
    private $anConstruction;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"show"})
     */
    private $anAchat;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"show"})
     */
    private $dateMiseVente;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $proprioNom;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\Range(min=18, max=100)
     */
    private $proprioAge;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $venteMotif;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Immo\Lot", mappedBy="bien")
     */
    private $lots;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creeLe;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $venduLe;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    private $prixNetVendeur;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    private $fraisAgence;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(min=5, max=100)
     */
    private $titre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    public function __construct()
    {
        $this->lots   = new ArrayCollection();
        $this->creeLe = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        $slugify = new Slugify();
        return $slugify->slugify($this->adresse);
    }

    /**
     * @return int
     */
    public function getBienType(): int
    {
        return $this->bienType;
    }

    /**
     * @param int $bienType
     * @return Bien
     */
    public function setBienType(int $bienType)
    {
        $this->bienType = $bienType;
        return $this;
    }

    public function getType()
    {
        return self::TYPE[$this->getBienType()];
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getAnConstruction(): ?int
    {
        return $this->anConstruction;
    }

    public function setAnConstruction(?int $anConstruction): self
    {
        $this->anConstruction = $anConstruction;

        return $this;
    }

    public function getAnAchat(): ?int
    {
        return $this->anAchat;
    }

    public function setAnAchat(?int $anAchat): self
    {
        $this->anAchat = $anAchat;

        return $this;
    }

    public function getDateMiseVente(): ?\DateTimeInterface
    {
        return $this->dateMiseVente;
    }

    public function setDateMiseVente(?\DateTimeInterface $dateMiseVente): self
    {
        $this->dateMiseVente = $dateMiseVente;

        return $this;
    }

    public function getProprioNom(): ?string
    {
        return $this->proprioNom;
    }

    public function setProprioNom(?string $proprioNom): self
    {
        $this->proprioNom = $proprioNom;

        return $this;
    }

    public function getProprioAge(): ?int
    {
        return $this->proprioAge;
    }

    public function setProprioAge(?int $proprioAge): self
    {
        $this->proprioAge = $proprioAge;

        return $this;
    }

    public function getVenteMotif(): ?string
    {
        return $this->venteMotif;
    }

    public function setVenteMotif(?string $venteMotif): self
    {
        $this->venteMotif = $venteMotif;

        return $this;
    }

    /**
     * @return Collection|Lot[]
     */
    public function getLots(): Collection
    {
        return $this->lots;
    }

    public function addLot(Lot $lot): self
    {
        if (!$this->lots->contains($lot)) {
            $this->lots[] = $lot;
            $lot->setBien($this);
        }

        return $this;
    }

    public function removeLot(Lot $lot): self
    {
        if ($this->lots->contains($lot)) {
            $this->lots->removeElement($lot);
            // set the owning side to null (unless already changed)
            if ($lot->getBien() === $this) {
                $lot->setBien(null);
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

    public function getVenduLe(): ?\DateTimeInterface
    {
        return $this->venduLe;
    }

    public function setVenduLe(?\DateTimeInterface $venduLe): self
    {
        $this->venduLe = $venduLe;

        return $this;
    }

    public function getPrixNetVendeur(): ?string
    {
        return $this->prixNetVendeur;
    }

    public function setPrixNetVendeur(?string $prixNetVendeur): self
    {
        $this->prixNetVendeur = $prixNetVendeur;

        return $this;
    }

    public function getFraisAgence(): ?string
    {
        return $this->fraisAgence;
    }

    public function setFraisAgence(?string $fraisAgence): self
    {
        $this->fraisAgence = $fraisAgence;

        return $this;
    }

    public function getPrixFAI(): float
    {
        return $this->getPrixNetVendeur() + $this->getFraisAgence();
    }
    public function getPrixFAIFormat(): string
    {

        return number_format($this->getPrixFAI(), 0, '', ' ');
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
