<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\PretService;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index()
    {
        $number = random_int(0, 100);
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'number' => $number,
        ]);
    }

    /**
     * @Route("/test-pret", name="testPret")
     * @throws \Exception
     */
    public function testPret()
    {
        $srv = (new PretService())
            ->setNbMois(240)
            ->setMtEmprunt(103040.8)
            ->setTxPret(0.012)
            ->setTxAss(0.0036)
            ->setDeb(new \Datetime('2020-01-01'));
//        $srv = new PretService();
//        dump($srv->test());
        $mens = $srv->getMensualiteBase();
        $tab = $srv->getTableauAmortissement();
//        dump($mens, $tab);
        return $this->render('immo/amortissement.html.twig', [
            'periodes' => $tab,
            'mens' => $mens,
        ]);
    }

    public function testPret2()
    {

    }
}
