<?php

namespace App\Entity\Immo;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Immo\LotRepository")
 */
class Lot
{
    const CHAUFFAGE = [
        0 => 'Électrique',
        1 => 'Gaz',
        2 => 'Convecteur',
        3 => 'Charbon',
        4 => 'Bois',
        5 => 'Solaire',
        6 => 'Pétrole'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $surface;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Immo\LotType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Immo\Bien", inversedBy="lots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bien;

    /**
     * @ORM\Column(type="smallint")
     */
    private $chauffageType;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function &getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getType(): ?LotType
    {
        return $this->type;
    }

    public function setType(?LotType $type): self
    {
        $this->type = $type;

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

    public function getChauffageType(): ?int
    {
        return $this->chauffageType;
    }

    public function setChauffageType(int $chauffageType): self
    {
        $this->chauffageType = $chauffageType;
        return $this;
    }

}
