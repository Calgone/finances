<?php

namespace App\Controller\Bourse;

use App\Entity\Bourse\Stock;
use App\Service\Bourse\StockService;
use App\Service\FinnhubService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StockController
 * @Route("/bourse")
 * @package App\Controller\Bourse
 */
class StockController extends AbstractController
{
//    private $projetRepo;
//    private $em;
    private $stockSrv;

    public function __construct(StockService $srv) //EntityManagerInterface $em)
    {
//        $this->projetRepo = $projetRepo;
//        $this->em = $em;
//        $this->stockSrv = new StockService($this->em);
        $this->stockSrv = $srv;
    }

    /**
     * @Route("/stock", name="bourse_stock")
     */
    public function index()
    {
        return $this->render('bourse/stock/index.html.twig', [
            'controller_name' => 'StockController',
        ]);
    }

    /**
     * @Route("/stock/{id}/detail", name="stock.detail")
     * @param Request $request
     * @return Response
     */
    public function stockDetail(Request $request)
    {
        $id    = $request->get('id');
        $stock = $this->stockSrv->getCurrentStock($id);
//        dd($stock);
        $this->stockSrv->setStock($stock);
//        $stockOrderHistory = $this->stockSrv->getStockOrderHistory();
        $stockPosition     = $this->stockSrv->getStockPosition();
        return $this->render('bourse/stock/detail.html.twig', [
                'stock'             => $stock,
//                'stockOrderHistory' => $stockOrderHistory,
                'stockPosition'     => $stockPosition
            ]
        );
    }

    /**
     * @Route("/stock/{id}/json", name="stock.json")
     * @param Request $request
     * @param Stock $stock
     * @return Response
     * @throws \Exception
     */
    public function stockJson(Request $request, Stock $stock)
    {

//        $stockSrv = new StockService($this->em);

        $method   = $request->request->get('method');
        $res      = $this->stockSrv->$method($stock);
        $response = ['message' => 'ok', 'data' => $res];
//        dd($stock);
//        $this->em->persist($stock);
//        $this->em->flush();
        $serializer = $this->get('serializer');
        $stockJson  = $serializer->serialize($response, 'json',
            [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]);
        return new Response($stockJson, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * Recherche une valeur via l'API et l'enregistre en base
     * @Route("/stock/search", name="stock.search")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function stockSearch(Request $request)
    {
        $isin = trim($request->request->get('stock_search'));
//        dd($isin);
        $stock        = $this->stockSrv->getProfile($isin);
        $response     = ['message' => 'ok', 'data' => $stock];
        $serializer   = $this->get('serializer');
        $responseJson = $serializer->serialize($response, 'json',
            [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]);
        return new Response($responseJson, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * Recherche une valeur dans la base locale
     * @Route("/stock/local_search", name="stock.local.search")
     * @param Request $request
     * @return JsonResponse
     */
    public function stockLocalSearch(Request $request)
    {
        $term = trim($request->request->get('term'));
//        dd($request->request->get('phrase'));
        $result = $this->stockSrv->searchLocalStock($term);

//        dd($result);
        $i        = 0;
        $response = [];
        foreach ($result as $k => $v) {
            $response[$i]['id']   = $v->getId();
            $response[$i]['name'] = $v->getName();
        }

//        $response = [['name' => 'abc'], ['name' => 'def'], ['name' => 'ghi']];
        return new JsonResponse($response, 200);
    }
}
