<?php

namespace App\Controller\Bourse;

use App\Entity\Bourse\Action;
use App\Service\Bourse\ActionService;
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
class ActionController extends AbstractController
{
//    private $projetRepo;
//    private $em;
    private $actionSrv;

    public function __construct(ActionService $srv) //EntityManagerInterface $em)
    {
//        $this->projetRepo = $projetRepo;
//        $this->em = $em;
//        $this->actionSrv = new StockService($this->em);
        $this->actionSrv = $srv;
    }

    /**
     * @Route("/action", name="action.index")
     */
    public function index()
    {
        return $this->render('bourse/action/index.html.twig', [
            'controller_name' => 'StockController',
        ]);
    }

    /**
     * @Route("/action/{id}/detail", name="action.detail")
     * @param Request $request
     * @return Response
     */
    public function actionDetail(Request $request)
    {
        $id    = $request->get('id');
        $action = $this->actionSrv->getActionCote($id);
//        dd($action);
        $this->actionSrv->setAction($action);
//        $stockOrderHistory = $this->actionSrv->getStockOrderHistory();
        $actionPosition = $this->actionSrv->getActionPosition();
        return $this->render('bourse/action/detail.html.twig', [
                'action'         => $action,
//                'stockOrderHistory' => $stockOrderHistory,
                'actionPosition' => $actionPosition
            ]
        );
    }

    /**
     * @Route("/action/{id}/json", name="action.json")
     * @param Request $request
     * @param Action $stock
     * @return Response
     * @throws \Exception
     */
    public function actionJson(Request $request, Action $stock)
    {
//        $actionSrv = new StockService($this->em);

        $method   = $request->request->get('method');
        $res      = $this->actionSrv->$method($stock);
        $response = ['message' => 'ok', 'data' => $res];
//        dd($action);
//        $this->em->persist($action);
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
     * Recherche une action via l'API et l'enregistre en base
     * @Route("/action/search", name="action.search")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function actionSearch(Request $request)
    {
        $isin = trim($request->request->get('action_search'));
//        dd($isin);
        $action = new Action();
        $action->setIsin($isin);
        $action        = $this->actionSrv->getProfile($action);
        $response     = ['message' => 'ok', 'data' => $action];
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
     * Recherche une action dans la base locale
     * @Route("/action/local_search", name="action.local.search")
     * @param Request $request
     * @return JsonResponse
     */
    public function stockLocalSearch(Request $request)
    {
        $term = trim($request->request->get('term'));
//        dd($request->request->get('phrase'));
        $result = $this->actionSrv->findActionLocal($term);

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

    /**
     * Renvoie le template du formulaire pour créer une alerte
     * @Route("/action/alert-form", name="action.alert-form")
     */
    public function actionAlerte()
    {
        return $this->render('bourse/action/alert.html.twig', [
            'controller_name' => 'StockController',
        ]);
    }
}