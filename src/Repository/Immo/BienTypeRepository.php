<?php

namespace App\Repository\Immo;

use App\Entity\Immo\BienType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BienType|null find($id, $lockMode = null, $lockVersion = null)
 * @method BienType|null findOneBy(array $criteria, array $orderBy = null)
 * @method BienType[]    findAll()
 * @method BienType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BienTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BienType::class);
    }

    // /**
    //  * @return BienType[] Returns an array of BienType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BienType
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
