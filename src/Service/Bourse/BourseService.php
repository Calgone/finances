<?php

namespace App\Service\Bourse;

use App\Entity\Bourse\Position;
use Doctrine\ORM\EntityManagerInterface;

class BourseService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Renvoie un tableau de toutes les positions en cours
     * @return Position[]
     */
    public function getPosition(): array
    {

    }
}