<?php

namespace App\Controller\Bourse;

use App\Entity\Bourse\Order;
use App\Entity\Bourse\Position;
use App\Entity\Bourse\Stock;
use App\Form\Bourse\OrderType;
use App\Service\DataTablesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OrderController
 * @package App\Controller\Bourse
 * @Route("/bourse")
 */
class OrderController extends AbstractController
{
    protected $em;
    protected $ordreRepo;

    public function __construct(EntityManagerInterface $em)
    {
//        dd($this->container);
        $this->em        = $em;
        $this->ordreRepo = $this->em->getRepository('App:Bourse\Order');
    }

    /**
     * @Route("/ordre", name="bourse_ordre")
     */
    public function index()
    {
        return $this->render('bourse/ordre/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }

    /**
     * @Route("/order/list")
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request)
    {
        $dtSrv = new DataTablesService();
        $dtSrv->getRequest($request);


        $response = ['draw'            => $dtSrv->getDraw(),
                     'recordsTotal'    => 2,
                     'recordsFiltered' => 2,
                     'data'            => [
                         ['date_ordre' => '2020-01-01', 'libelle' => 'Nike'],
                         ['date_ordre' => '2020-01-02', 'libelle' => 'Intel']
                     ]
        ];
        return new JsonResponse($response);
    }

    /**
     * @Route("/stock/{id}/order/new", name="order.new")
     * @param Request $request
     * @param Stock $stock
     * @return Response|RedirectResponse
     */
    public function new(Request $request, Stock $stock)
    {
        $order = new Order();
        $order->setStock($stock);
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer la position. Si achat: création, si vente: suppression

            if ($order->getDirection() === 'buy') {
                $position = new Position();
                $position->setStock($stock);
                $position->setCreatedAt(new \DateTime());
                $position->setUnitCost($order->getQuotation());
                $position->setVolume($order->getVolume());
                $this->em->persist($position);
            } else { // 'sell'
                $positionRepo = $this->em->getRepository(Position::class);
                $position = $positionRepo->findOneBy(['stock' => $stock]);
                $this->em->remove($position);
            }

            $this->em->persist($order);
            $this->em->flush();
            $this->addFlash('success',"L'ordre est enregistré.");
            return $this->redirectToRoute('bourse.index');
        }

        return $this->render('bourse/ordre/new.html.twig', [
            'form' => $form->createView(),
            'order' => $order // utilisé pour afficher les données hors du form
        ]);
    }
}
