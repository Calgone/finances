<?php

namespace App\Controller;

use App\Entity\Immo\Bien;
use App\Repository\Immo\BienRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ImmoController extends AbstractController
{

    private $bienRepo;
    private $em;

    public function __construct(BienRepository $bienRepo, EntityManagerInterface $em)
    {
        $this->bienRepo = $bienRepo;
        $this->em = $em;
    }

    /**
     * @Route("/immo", name="immo")
     */
    public function index()
    {
        $biens = $this->bienRepo->findLatest();

        return $this->render('immo/index.html.twig', [
            'controller_name' => 'ImmoController',
            'biens' => $biens,
        ]);
    }

    /**
     * @Route("/immo/bien/new", name="bien.new")
     * @return Response
     */
    public function newBien()
    {
        $bien = new Bien();
        $bien->setAdresse('Rue des prés')
            ->setVille('Aire sur la Lys')
            ->setCp('62120');
//        $em = $this->getDoctrine()->getManager();

        $this->em->persist($bien);
        $this->flush();

        return $this->render('immo/bien.html.twig', [
            'bien' => $bien,
        ]);
    }

    /**
     * @Route("/immo/bien/{slug}-{id}", name="bien.show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function showBien(Bien $bien, string $slug): Response
    {
        if ($bien->getSlug() !== $slug) {
            return $this->redirectToRoute('bien.show', [
                'id' => $bien->getId(),
                'slug' => $bien->getSlug()
            ], 301);
        }
//        $repo = $this->getDoctrine()->getRepository(Bien::class);
//        dump($this->bienRepo);
//        $bien = $this->bienRepo->findAll();
//        dump($bien);
        return $this->render('immo/bien.html.twig', [
            'bien' => $bien,
        ]);
    }

    /**
     * @Route("/immo/bien/update/{id}", name="bien.update")
     */
    public function updateBien(Bien $bien)
    {
//        $bien = $this->bienRepo->;
        $bien->setVille('ma new ville');
        $this->em->flush();
        return $this->render('immo/bien.html.twig', [
            'bien' => $bien,
        ]);
    }
}
