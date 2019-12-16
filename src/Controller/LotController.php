<?php

namespace App\Controller;

use App\Entity\Immo\Lot;
use App\Form\LotType;
use App\Repository\Immo\LotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LotController extends AbstractController
{
    private $lotRepo;
    private $em;

    public function __construct(LotRepository $lotRepo, EntityManagerInterface $em)
    {
        $this->lotRepo = $lotRepo;
        $this->em = $em;
    }

    /**
     *
     * Récupère l'ensemble des lots d'un bien
     * @Route("/bien/lot", name="lot.index")
     * @return Response
     */
    public function index()
    {
        $biens = $this->lotRepo->findAll();

        return $this->render('lot/index.html.twig', compact('biens'));
    }

    /**
     * @Route("/bien/log/new", name="lot.new")
     */
    public function new(Request $request)
    {
        $lot = new Lot;
        $form = $this->createForm(LotType::class, $lot);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
//            dump('valid');
            $this->em->persist($lot);
            $this->em->flush();
            return $this->redirectToRoute('lot.index');
        }
        return $this->render('lot/new.html.twig', [
            'lot' => $lot,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/bien/lot/{id}", name="lot.edit")
     * @param Lot $lot
     * @param Request $request
     * @return Response
     */
    public function edit(Lot $lot, Request $request)
    {
        $form = $this->createForm(LotType::class, $lot);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
//            dump('valid');
            $this->em->flush();
            return $this->redirectToRoute('lot.index');
        }
        return $this->render('lot/edit.html.twig', [
            'lot' => $lot,
            'form' => $form->createView()
        ]);
    }
}
