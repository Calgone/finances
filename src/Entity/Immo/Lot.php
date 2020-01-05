<?php

namespace App\Entity\Immo;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


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

    const TYPE = [
        0 => 'studio',
        1 => 'T1',
        2 => 'T2',
        3 => 'T3',
        4 => 'T4',
        5 => 'maison',
        6 => 'garage',
        7 => 'local commercial'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\Range(min=10, max=400)
     */
    private $surface;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotNull()
     */
    private $lotType;

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

    public function getLotType(): ?int
    {
        return $this->lotType;
    }

    public function setLotType(int $lotType): self
    {
        $this->lotType = $lotType;

        return $this;
    }

    public function getType(): string
    {
        return self::TYPE[$this->getLotType()];
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

    public function getChauffage(): string
    {
        return self::CHAUFFAGE[$this->getChauffageType()];
    }
}
