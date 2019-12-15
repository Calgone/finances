<?php

namespace App\Repository\Immo;

use App\Entity\Immo\LotType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LotType|null find($id, $lockMode = null, $lockVersion = null)
 * @method LotType|null findOneBy(array $criteria, array $orderBy = null)
 * @method LotType[]    findAll()
 * @method LotType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LotTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LotType::class);
    }

    // /**
    //  * @return LotType[] Returns an array of LotType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LotType
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
