<?php

namespace App\Controller\Bourse;

use App\Entity\Bourse\Action;
use App\Entity\Bourse\Alerte;
use App\Entity\Bourse\AlerteModele;
use App\Form\Bourse\AlerteType;
use App\Repository\Bourse\AlerteModeleRepository;
use App\Service\Bourse\ActionService;
use App\Service\FinnhubService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ActionController
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
//        $this->actionSrv = new ActionService($this->em);
        $this->actionSrv = $srv;
    }

    /**
     * @Route("/action", name="action.index")
     */
    public function index()
    {
        return $this->render('bourse/action/index.html.twig', [
            'controller_name' => 'ActionController',
        ]);
    }

    /**
     * @Route("/action/{id}/detail", name="action.detail")
     * @param Request $request
     * @return Response
     */
    public function actionDetail(Request $request): Response
    {
        $id     = $request->get('id');
        $action = $this->actionSrv->getActionCote($id);
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
     * @param Action $action
     * @return Response
     * @throws \Exception
     */
    public function actionJson(Request $request, Action $action): Response
    {
//        $actionSrv = new StockService($this->em);

        $method   = $request->request->get('method');
        $res      = $this->actionSrv->$method($action);
        $response = ['message' => 'ok', 'data' => $res];
//        dd($action);
//        $this->em->persist($action);
//        $this->em->flush();
        $serializer = $this->get('serializer');
        $actionJson = $serializer->serialize($response, 'json',
            [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]);
        return new Response($actionJson, 200, [
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
    public function actionSearch(Request $request): Response
    {
        $isin   = trim($request->request->get('action_search'));
        $action = $this->actionSrv->findActionFromISIN($isin);
        if (!$action) {
            $response = "Aucune action trouvée pour l'isin " . $isin;
        } else {
            $url  = $this->generateUrl('action.detail', ['id' => $action->getId()]);
            $response = '<a href="' . $url . '">' . $action->getNom() . '</a>';
        }
//        $response     = ['message' => 'ok', 'data' => $action];
//        $serializer   = $this->get('serializer');
//        $responseJson = $serializer->serialize($response, 'json',
//            [
//                'circular_reference_handler' => function ($object) {
//                    return $object->getId();
//                }
//            ]);
//        return new Response($responseJson, 200, [
//            'Content-Type' => 'application/json'
//        ]);
        return new Response($response, 200);
    }

    /**
     * Recherche une action dans la base locale
     * @Route("/action/local_search", name="action.local.search")
     * @param Request $request
     * @return JsonResponse
     */
    public function stockLocalSearch(Request $request): JsonResponse
    {
        $term = trim($request->request->get('term'));
//        dd($request->request->get('phrase'));
        $result = $this->actionSrv->findActionLocal($term);

//        dd($result);
        $i        = 0;
        $response = [];
        foreach ($result as $k => $v) {
            $response[$i]['id']  = $v->getId();
            $response[$i]['nom'] = $v->getNom();
        }

//        $response = [['name' => 'abc'], ['name' => 'def'], ['name' => 'ghi']];
        return new JsonResponse($response, 200);
    }

    // Utilisation des forms Symfony pour les alertes

    /**
     * @Route("/action/{id}/alerte/new", name="action.alerte.new")
     * @param Request $request
     * @param Action $action
     */
    public function newAlerte(Request $request, Action $action)
    {
        $alerte = new Alerte();
        $alerte->setAction($action);
        $form = $this->createForm(AlerteType::class, $alerte);

        return $this->render('bourse/action/alerte/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    // Ci-dessous façon d'origine
    /**
     * Renvoie le template du formulaire pour créer une alerte
     * @Route("/action/get-alert-form", name="action.get-alert-form")
     */
    public function actionGetAlertForm(): Response
    {
        $alerteModeles = $this->actionSrv->getAllAlerteModeles();

        return $this->render('bourse/action/alert.html.twig', [
            'controller_name' => 'ActionController',
            'alerteModeles'   => $alerteModeles,
        ]);
    }

    /**
     * @Route("/action/submit-alert-form", name="action.submit-alert-form")
     * @param Request $request
     * @return Response
     */
    public function actionSubmitAlertForm(Request $request): Response
    {
//        dd($request->request->get('alerteModele'));
        $alerteModele = (new AlerteModeleRepository())->findOne($request->request->get('alerteModele'));
//        $alerteModele = $request->request->get('alerteModele');
        $seuilBas = $request->request->get('seuilBas');
        $seuilHaut = $request->request->get('seuilHaut');
        $variation = $request->request->get('variation');
        $methode = $request->request->get('methode');
        $referentiel = $request->request->get('referentiel');
        $freqVal = $request->request->get('freqVal');
        $freqType = $request->request->get('freqType');
        $alert = new Alerte();
        $alert->setAlerteModele($alerteModele)
            ->setSeuilBas($seuilBas)
            ->setSeuilHaut($seuilHaut)
            ->setVariation($variation)
            ->setMethode($methode)
            ->setReferentiel($referentiel)
            ->setFreqVal($freqVal)
            ->setFreqType($freqType);
        return new Response('ok', 200);
    }
}
