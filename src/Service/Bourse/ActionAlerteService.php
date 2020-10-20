<?php


namespace App\Service\Bourse;


use App\Entity\Bourse\Position;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;

class ActionAlerteService extends ActionService
{

    public function __construct(EntityManagerInterface $em, MailerInterface $mailer)
    {
        parent::__construct($em, $mailer);
    }

    public function getHistoricalVariation()
    {
        $positions = $this->em->getRepository(Position::class)->findAll();
        dd($positions);
    }
}