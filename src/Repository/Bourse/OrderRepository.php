<?php

namespace App\Repository\Bourse;

use App\Entity\Bourse\Ordre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ordre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ordre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ordre[]    findAll()
 * @method Ordre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ordre::class);
    }

    /**
     * @return Ordre[]
     */
    public function findLastTrades(): array
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT o
            FROM App\Entity\Bourse\Ordre o
            ORDER BY o.date DESC
            '
        )->setMaxResults(5);
        return $query->getResult();
    }
    // /**
    //  * @return Order[] Returns an array of Order objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Order
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
