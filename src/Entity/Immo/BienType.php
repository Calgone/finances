<?php

namespace App\Entity\Immo;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Immo\BienTypeRepository")
 */
class BienType
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
    private $bien_type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBienType(): ?string
    {
        return $this->bien_type;
    }

    public function setBienType(string $bien_type): self
    {
        $this->bien_type = $bien_type;

        return $this;
    }
}
