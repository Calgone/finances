<?php

namespace App\Controller;

use App\Entity\Immo\Projet;
use App\Form\ProjetType;
use App\Repository\Immo\ProjetRepository;
use App\Service\PretService;
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

    /**
     * @Route("/projet/{id}/detail", name="projet.detail")
     */
    public function detail(Projet $projet)
    {
        $serializer = $this->get('serializer');
        $projetJson = $serializer->serialize($projet, 'json',
            [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]);

//        dump($projet);
        // Infos du prêt
        $mt_emprunt =
        $pretSrv = (new PretService()) // TODO voir pour intégrer le service prêt dans le modèle projet
            ->setNbMois($projet->getCreditDureeMois())
            ->setMtEmprunt($projet->getCreditMontant())
            ->setTxPret($projet->getCreditTaux() / 100)
            ->setTxAss($projet->getCreditTauxAss() / 100)
            ->setDeb($projet->getCreditDateDebut());
//        $srv = new PretService();
//        dump($srv->test());
        $mens = $pretSrv->getMensualiteBase();
        return $this->render('immo/projet/detail.html.twig', [
            'projet' => $projet,
            'projetJson' => $projetJson,
            'mens' => $mens
        ]);
    }
}
