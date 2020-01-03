<?php

namespace App\Controller;

use App\Entity\Immo\Bien;
use App\Form\BienType;
use App\Repository\Immo\BienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BienController
 * @package App\Controller
 * @Route("/immo")
 */
class BienController extends AbstractController
{
    private $bienRepo;
    private $em;

    public function __construct(BienRepository $bienRepo, EntityManagerInterface $em)
    {
        $this->bienRepo = $bienRepo;
        $this->em       = $em;
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

        return $this->render('immo/bien/index.html.twig', compact('biens'));
    }

    /**
     * @Route("/bien/{id}/detail", name="bien.show")
     * @param Bien $bien
     * @return Response
     */
    public function show(Bien $bien): Response
    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        // or add an optional message - seen by developers
//        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
//        if ($bien->getSlug() !== $slug) {
//            return $this->redirectToRoute('bien.show', [
//                'id' => $bien->getId(),
//                'slug' => $bien->getSlug()
//            ], 301);
//        }
//        $repo = $this->getDoctrine()->getRepository(Bien::class);
//        dump($this->bienRepo);
//        $bien = $this->bienRepo->findAll();
//        dump($bien);
        return $this->render('immo/bien.html.twig', [
            'bien' => $bien,
        ]);
    }

    /**
     * @Route("/bien/new", name="bien.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request)
    {
        $bien = new Bien();
        $form = $this->createForm(BienType::class, $bien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($bien);
            $this->em->flush();
            $this->addFlash('success','Le bien est créé');
        }
        return $this->render('immo/bien/new.html.twig', [
            'bien' => $bien,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/bien/{id}", name="bien.edit", requirements={"id"="\d+"}, methods={"GET","POST"})
     * @param Bien $bien
     * @param Request $request
     * @return Response
     */
    public function edit(Bien $bien, Request $request)
    {
        $form = $this->createForm(BienType::class, $bien);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success','Le bien est sauvegardé');
            return $this->redirectToRoute('bien.index');
        }
        return $this->render('immo/bien/edit.html.twig', [
            'bien' => $bien,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/bien/{id}", name="bien.delete", methods="DELETE", requirements={"id"="\d+"})
     * @param Bien $bien
     * @param Request $request
     * @return Response
     */
    public function delete(Bien $bien, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $bien->getId(), $request->get('_token'))) {
            $this->em->remove($bien);
            $this->em->flush();
            $this->addFlash('success','Le bien est supprimé');
            return $this->redirectToRoute('immo.index');
        } else {
            return $this->redirectToRoute('bien.edit', ['id' => $bien->getId()]);
        }
    }
}
