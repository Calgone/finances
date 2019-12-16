<?php

namespace App\Controller;

use App\Entity\Immo\Bien;
use App\Form\BienType;
use App\Repository\Immo\BienRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class BienController extends AbstractController
{
    private $bienRepo;

    public function __construct(BienRepository $bienRepo)
    {
        $this->bienRepo = $bienRepo;
    }

    /**
     *
     * Récupère l'ensemble des biens
     * @Route("/bien", name="bien.index")
     * @return Response
     */
    public function index()
    {
        $biens = $this->bienRepo->findAll();

        return $this->render('bien/index.html.twig', compact('biens'));
    }

    /**
     * @Route("/bien/{id}", name="bien.edit", requirements={"id"="\d+"})
     * @return Response
     */
    public function edit(Bien $bien)
    {
        $form = $this->createForm(BienType::class, $bien);
        return $this->render('bien/edit.html.twig', [
            'bien' => $bien,
            'form' => $form->createView()
        ]);
    }
}
