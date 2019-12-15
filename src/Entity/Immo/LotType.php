<?php

namespace App\Entity\Immo;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Immo\LotTypeRepository")
 */
class LotType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $lot_type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLotType(): ?string
    {
        return $this->lot_type;
    }

    public function setLotType(string $lot_type): self
    {
        $this->lot_type = $lot_type;

        return $this;
    }
}
