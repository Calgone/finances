<?php


namespace App\Service\Bourse;

use App\Entity\Bourse\AlerteModele;
use App\Entity\Bourse\Position;
use App\Entity\Bourse\Cote;
use App\Entity\Bourse\Action;
use App\Repository\Bourse\AlerteModeleRepository;
use App\Service\FinnhubService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Mailer\MailerInterface;

class ActionService
{
    protected $em;
    protected $mailer;
    protected $fhSrv;
    protected $actionRepo;

    /**
     * @var Action
     */
    private $action;
    /**
     * @var AlerteModeleRepository|\Doctrine\Persistence\ObjectRepository
     */
    private $alerteModeleRepo;

    public function __construct(EntityManagerInterface $em, MailerInterface $mailer)
    {
        $this->em               = $em;
        $this->mailer           = $mailer;
        $this->fhSrv            = new FinnhubService();
        $this->actionRepo       = $this->em->getRepository(Action::class);
        $this->alerteModeleRepo = $this->em->getRepository(AlerteModele::class);
    }

    public function setAction(Action $action)
    {
        $this->action = $action;
    }

    /**
     * @param Action $action
     * @return Action|null
     * @throws \Exception
     */
    public function getProfile(Action $action): ?Action
    {
//        $action = new Stock();
//        $action->setIsin($isin);
        $res = $this->fhSrv->getProfile($action->getIsin());
//        var_dump($res);
        if (!empty($res)) {
            $action->setIpo(new \Datetime($res->ipo));
            //        $action->setCountry($res->country);
            $action->setCapitalisation($res->marketCapitalization);
            $action->setNom($res->name);
            $action->setTel($res->phone);
            $action->setActionsEnCirculation($res->shareOutstanding);
            $action->setTicker($res->ticker);
            $action->setWebUrl($res->weburl);
            $action->setLogo($res->logo);
            $this->em->persist($action);
            $this->em->flush();
            return $action;
        } else {
            return null;
        }

    }

    public function getBasicFinancial(Action $action)
    {
        $res = $this->fhSrv->getBasicFinancial($action->getTicker());
//        dd($res);
        return $res;
    }

    public function getCote(Action $action)
    {
        $res  = $this->fhSrv->getQuote($action->getTicker());
        $cote = new Cote();
        $cote->setPrix($res->c);
        $cote->setPrixMax($res->h);
        $cote->setPrixMin($res->l);
        $cote->setPrixOuverture($res->o);
        $cote->setPrixClotureVeille($res->pc);
//        $cote->setCreeLe((new \DateTime)->setTimestamp($res->t));
        $cote->setAction($action);
        $this->em->persist($cote);
        $this->em->flush();
        return $action;

//        return $res;
//        dd($res);
    }

    public function getActionCote(int $id)
    {
        return $this->actionRepo->getActionCote($id);
    }


    public function findActionLocal(string $term): array
    {
        $query = $this->actionRepo->createQueryBuilder('s')
            ->where('s.nom LIKE :term')
            ->orWhere('s.isin LIKE :term')
            ->orWhere('s.ticker LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->getQuery();
        return $query->getResult();
    }

    // Les 2 méthodes peuvent être remplacées par les relations dans l'entité
//    /**
//     * Returns all orders on that Stock
//     */
//    public function getStockOrderHistory(): array
//    {
//        $query = $this->em->createQuery('
//                SELECT o
//                FROM App\Entity\Bourse\Order o
//                WHERE o.action = :action
//        ')->setParameter('action', $this->action);
//        return $query->getResult();
//    }

    /**
     * @return Position|null
     * @throws NonUniqueResultException
     */
    public function getActionPosition(): ?Position
    {
        $query = $this->em->createQuery('
            SELECT p
            FROM App\Entity\Bourse\Position p
            WHERE p.action=:action
        ')->setParameter('action', $this->action);
        return $query->getOneOrNullResult();

    }

    /**
     * @return AlerteModele[]
     */
    public function getAllAlerteModeles(): array
    {
        return $this->alerteModeleRepo->findAll();
    }

    /**
     * @param string $isin
     * @return Action|null
     * @throws \Exception
     */
    public function findActionFromISIN(string $isin): ?Action
    {
        // on cherche si on a déjà l'action en local
        $action = $this->actionRepo->findOneBy(['isin' => $isin]);
        if (!$action) {
            $action = new Action();
            $action->setIsin($isin);
        }
        if ($action) {
            $this->action = $this->getProfile($action);;
            return $this->action;
        } else {
            return null;
        }
    }

    public function saveAlerte()
    {

    }
}