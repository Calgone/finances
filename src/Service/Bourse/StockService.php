<?php


namespace App\Service\Bourse;

use App\Entity\Bourse\Quote;
use App\Entity\Bourse\Stock;
use App\Service\FinnhubService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;

class StockService
{
    protected $em;
    protected $mailer;
    protected $fhSrv;
    protected $stockRepo;

    /**
     * @var Stock
     */
    private $stock;

    public function __construct(EntityManagerInterface $em, MailerInterface $mailer)
    {
        $this->em        = $em;
        $this->mailer    = $mailer;
        $this->fhSrv     = new FinnhubService();
        $this->stockRepo = $this->em->getRepository(Stock::class);
    }

    public function setStock(Stock $stock)
    {
        $this->stock = $stock;
    }

    /**
     * @param string $isin
     * @return Stock|null
     * @throws \Exception
     */
    public function getProfile(string $isin):? Stock
    {
        $stock = new Stock();
        $stock->setIsin($isin);

        $res = $this->fhSrv->getProfile($stock->getIsin());
//        var_dump($res);
        if (!empty($res)) {
            $stock->setIpo(new \Datetime($res->ipo));
            //        $stock->setCountry($res->country);
            $stock->setMarketCap($res->marketCapitalization);
            $stock->setName($res->name);
            $stock->setTel($res->phone);
            $stock->setShareOutstanding($res->shareOutstanding);
            $stock->setTicker($res->ticker);
            $stock->setWebUrl($res->weburl);
            $stock->setLogo($res->logo);
            $this->em->persist($stock);
            $this->em->flush();
            return $stock;
        } else {
            return null;
        }

    }

    public function getBasicFinancial(Stock $stock)
    {
        $res = $this->fhSrv->getBasicFinancial($stock->getTicker());
//        dd($res);
        return $res;
    }

    public function getQuote(Stock $stock)
    {
        $res   = $this->fhSrv->getQuote($stock->getTicker());
        $quote = new Quote();
        $quote->setCurrentPrice($res->c);
        $quote->setHighPrice($res->h);
        $quote->setLowPrice($res->l);
        $quote->setOpenPrice($res->o);
        $quote->setPreviousClosePrice($res->pc);
        $quote->setPriceAt((new \DateTime)->setTimestamp($res->t));
        $quote->setStock($stock);
        $this->em->persist($quote);
        $this->em->flush();
        return $stock;

//        return $res;
//        dd($res);
    }

    public function getCurrentStock(int $id)
    {
        return $this->stockRepo->getCurrentStock($id);
    }


    public function searchLocalStock(string $term): array
    {
        $repo  = $this->em->getRepository("App:Bourse\Stock");
        $query = $repo->createQueryBuilder('s')
            ->where('s.name LIKE :term')
            ->orWhere('s.isin LIKE :term')
            ->orWhere('s.ticker LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->getQuery();
        return $query->getResult();
    }
}