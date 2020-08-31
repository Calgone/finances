<?php

namespace App\Repository\Bourse;

use App\Entity\Bourse\Stock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stock|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stock|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stock[]    findAll()
 * @method Stock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stock::class);
    }

    // /**
    //  * @return Stock[] Returns an array of Stock objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stock
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Renvoie le Stock avec la dernière quotation (quote)
     * @param int $id
     * @return int|mixed|string
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getCurrentStock(int $id): Stock
    {
        $query = $this->createQueryBuilder('stock');
        $query
            ->leftJoin('stock.quotes', 'quotes')
            ->leftJoin('App\Entity\Bourse\Quote', 'last_quote',
                'WITH',
                'stock=last_quote.stock AND quotes.id < last_quote.id')
            ->where('last_quote.id IS NULL')
            ->andWhere('stock.id = :id')
            ->setParameter('id', $id)
            ->select('stock', 'quotes');
        return $query->getQuery()->getSingleResult();
    }
}
