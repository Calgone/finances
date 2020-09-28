<?php

namespace App\Controller\Bourse;

use App\Entity\Bourse\Stock;
use App\Entity\Bourse\Position;
use App\Service\Bourse\BourseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class BourseController
 * @package App\Controller\Bourse
 * @Route("/bourse")
 */
class BourseController extends AbstractController
{
    protected $em;
    protected $positionRepo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em           = $em;
        $this->positionRepo = $this->em->getRepository(Position::class);
    }

    /**
     * @Route("/", name="bourse.index")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('bourse/bourse/index.html.twig', [
            'controller_name' => 'BourseController',
        ]);
    }

    /**
     * @Route("/position", name="bourse.position")
     * @return Response
     */
    public function position()
    {
        return $this->render('bourse/bourse/position.html.twig');
    }

    /**
     * Get Datatable results for Positions
     * see http://growingcookies.com/datatables-server-side-processing-in-symfony/
     * @Route("/position/list", name="position.list")
     * @param Request $request
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    public function positionList(Request $request)
    {
//        $bourseSrv  = new BourseService($this->em);

        // Get the parameters from Datatable Ajax call
        if ($request->getMethod() === 'POST') {
            $draw    = intval($request->request->get('draw'));
            $start   = $request->request->get('start');
            $length  = $request->request->get('length');
            $search  = $request->request->get('search');
            $orders  = $request->request->get('order');
            $columns = $request->request->get('columns');
        } else {
            die;
        }
//        dd($draw, $start, $length, $search, $orders, $columns);

        // Orders
        foreach ($orders as $key => $order) {
            // Orders does not contain the name of the column, but its number,
            // so add the name so we can handle it just like the $columns array
            $orders[$key]['name'] = $columns[$order['column']]['name'];
        }

        //$positions = $this->em->getRepository(Position::class)->findAll();
        $results = $this->positionRepo->getRequiredDTData(
            $start, $length, $orders, $search, $columns);
//        dd($results);
        // Returned objects are of type Position
        /**
         * @var Position[]
         */
        $objects = $results["results"];
        // Get total number of objects
        $total_objects_count = $this->positionRepo->count([]);
        // Get total number of results
        $selected_objects_count = count($objects);
        // Get total number of filtered data
        $filtered_objects_count = $results["countResult"];

        $responseData = [];
        $i            = 0;
        $fmt          = new \NumberFormatter('fr_FR', \NumberFormatter::CURRENCY);
        foreach ($objects as $key => $position) {
            $url  = $this->generateUrl('stock.detail',
                ['id' => $position->getStock()->getId()]);
            $href = '<a href="' . $url . '">' . $position->getStock()->getName() . '</a>';
//            dd($position->getStock()->getQuotes()[0]->getCurrentPrice());
            $currentPrice       = $position->getStock()->getQuotes()[0]->getCurrentPrice();
            $currentAmount      = $currentPrice * $position->getVolume();
            $initialAmount      = $position->getUnitCost() * $position->getVolume();
            $capitalGain        = $currentAmount - $initialAmount;
            $capitalGainPercent = round(($capitalGain / $currentAmount) * 100,2);

            $responseData[$i]['name']               = $href;
            $responseData[$i]['volume']             = $position->getVolume();
            $responseData[$i]['unitCost']           = $fmt->formatCurrency($position->getUnitCost(), "EUR");
            $responseData[$i]['quote']              = $fmt->formatCurrency($currentPrice, "EUR");
            $responseData[$i]['amount']             = $fmt->formatCurrency($currentAmount, "EUR");
            $responseData[$i]['capitalGain']        = $fmt->formatCurrency($capitalGain, "EUR");
            $responseData[$i]['capitalGainPercent'] = number_format($capitalGainPercent, 2, ',', ' ') . ' %' ;
            $responseData[$i]['lastMovement']       = '2020-01-02 13:42:23';
            $i++;
        }

//        return new Response($responseJson, 200, [
//            'Content-Type' => 'application/json'
//        ]);

        $response = [
            'draw'            => $draw,
            'recordsTotal'    => $total_objects_count,
            'recordsFiltered' => $filtered_objects_count,
            'data'            => $responseData
        ];
        return new JsonResponse($response);
    }
}
