<?php

namespace App\Controller;

use App\Service\FinnhubService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\PretService;
use App\Service\InseeSireneService;

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

    /**
     * @Route("/test-insee", name="testInseeAPI")
     *
     */
    public function testInseeAPI()
    {
        $srv = new InseeSireneService();
        $res = $srv->rechercheParSiret('42206023600086');
        dump($res);
        return new Response('<body>success</body>');
    }

    /**
     * @Route("/test-finnhub")
     */
    public function testFinnhub()
    {
        $srv = new FinnhubService();
        $res = $srv->stockProfile('FR0000120628'); // AXA
        dump($res);
        return new Response('<body>success</body>');
    }

    /**
     * @Route("/test-email")
     * @param MailerInterface $mailer
     * @throws TransportExceptionInterface
     */
    public function testMail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from("finances.gregorylecubin@gmail.com")
            ->to("gregory.lecubin@gmail.com")
            ->subject("Un petit test de mail Symfony")
            ->text('Hi there')
            ->html('<p>Hello World !</p>');
        $mailer->send($email);
    }
}
