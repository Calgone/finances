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
     * @Assert\Length(min="2", minMessage="La valeur minimum autorisée est {{ limit }}",max="100", maxMessage="La valeur maximum autorisée est {{ limit }}")
     */
    private $ville;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"list", "show"})
     */
    private $an_construction;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"show"})
     */
    private $an_achat;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"show"})
     */
    private $date_mise_vente;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $proprio_nom;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Assert\Range(min=18, max=100)
     */
    private $proprio_age;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vente_motif;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Immo\Lot", mappedBy="bien")
     */
    private $lots;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $vendu_le;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    private $prix_net_vendeur;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2, nullable=true)
     */
    private $frais_agence;

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
        $this->lots       = new ArrayCollection();
        $this->created_at = new \DateTime();
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
        return $this->an_construction;
    }

    public function setAnConstruction(?int $an_construction): self
    {
        $this->an_construction = $an_construction;

        return $this;
    }

    public function getAnAchat(): ?int
    {
        return $this->an_achat;
    }

    public function setAnAchat(?int $an_achat): self
    {
        $this->an_achat = $an_achat;

        return $this;
    }

    public function getDateMiseVente(): ?\DateTimeInterface
    {
        return $this->date_mise_vente;
    }

    public function setDateMiseVente(?\DateTimeInterface $date_mise_vente): self
    {
        $this->date_mise_vente = $date_mise_vente;

        return $this;
    }

    public function getProprioNom(): ?string
    {
        return $this->proprio_nom;
    }

    public function setProprioNom(?string $proprio_nom): self
    {
        $this->proprio_nom = $proprio_nom;

        return $this;
    }

    public function getProprioAge(): ?int
    {
        return $this->proprio_age;
    }

    public function setProprioAge(?int $proprio_age): self
    {
        $this->proprio_age = $proprio_age;

        return $this;
    }

    public function getVenteMotif(): ?string
    {
        return $this->vente_motif;
    }

    public function setVenteMotif(?string $vente_motif): self
    {
        $this->vente_motif = $vente_motif;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getVenduLe(): ?\DateTimeInterface
    {
        return $this->vendu_le;
    }

    public function setVenduLe(?\DateTimeInterface $vendu_le): self
    {
        $this->vendu_le = $vendu_le;

        return $this;
    }

    public function getPrixNetVendeur(): ?string
    {
        return $this->prix_net_vendeur;
    }

    public function setPrixNetVendeur(?string $prix_net_vendeur): self
    {
        $this->prix_net_vendeur = $prix_net_vendeur;

        return $this;
    }

    public function getFraisAgence(): ?string
    {
        return $this->frais_agence;
    }

    public function setFraisAgence(?string $frais_agence): self
    {
        $this->frais_agence = $frais_agence;

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
