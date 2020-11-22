<?php

namespace App\Repository\Bourse;

use App\Entity\Bourse\AlerteModele;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AlerteModele|null find($id, $lockMode = null, $lockVersion = null)
 * @method AlerteModele|null findOneBy(array $criteria, array $orderBy = null)
 * @method AlerteModele[]    findAll()
 * @method AlerteModele[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlerteModeleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlerteModele::class);
    }

    // /**
    //  * @return AlerteModele[] Returns an array of AlerteModele objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AlerteModele
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
