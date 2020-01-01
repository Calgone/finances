<?php

namespace App\Controller;

use App\Entity\Immo\Projet;
use App\Form\ProjetType;
use App\Repository\Immo\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProjetController
 * @package App\Controller
 * @Route("/immo")
 */
class ProjetController extends AbstractController
{

    private $projetRepo;
    private $em;

    public function __construct(ProjetRepository $projetRepo, EntityManagerInterface $em)
    {
        $this->projetRepo = $projetRepo;
        $this->em = $em;
    }

    /**
     * @Route("/projet", name="projet.index")
     */
    public function index()
    {
        $projets = $this->projetRepo->findAll();

        return $this->render('immo/projet/index.html.twig', [
            'projets' => $projets,
        ]);
    }

    /**
     * Crée un projet
     *
     * @Route("/projet/new", name="projet.new")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($projet);
            $this->em->flush();
            return $this->redirectToRoute('immo.index');
        }
        return $this->render('immo/projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form->createView()
        ]);
    }

    /**
     * Modifie un projet
     * @Route("/projet/{id}", name="projet.edit")
     */
    public function edit(Projet $projet, Request $request)
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success','Le projet est sauvegardé');
            return $this->redirectToRoute('projet.index');
        }
        return $this->render('immo/projet/edit.html.twig', [
            'bien' => $projet,
            'form' => $form->createView()
        ]);
    }

    /**
     * Supprime un projet
     * @Route("/projet/{id}", name="projet.delete")
     */
    public function delete()
    {

    }
}
