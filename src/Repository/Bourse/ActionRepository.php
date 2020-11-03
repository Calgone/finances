<?php

namespace App\Repository\Bourse;

use App\Entity\Bourse\Action;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Action|null find($id, $lockMode = null, $lockVersion = null)
 * @method Action|null findOneBy(array $criteria, array $orderBy = null)
 * @method Action[]    findAll()
 * @method Action[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Action::class);
    }

    // /**
    //  * @return Action[] Returns an array of Action objects
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
    public function findOneBySomeField($value): ?Action
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
     * Renvoie l'action avec la dernière cote (quote)
     * @param int $id
     * @return int|mixed|string
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getActionCote(int $id): Action
    {
        $query = $this->createQueryBuilder('action');
        $query
            ->leftJoin('action.cotes', 'cotes')
            ->leftJoin('App\Entity\Bourse\Cote', 'last_cote',
                'WITH',
                'action=last_cote.action AND cotes.id < last_cote.id')
            ->where('last_cote.id IS NULL')
            ->andWhere('action.id = :id')
            ->setParameter('id', $id)
            ->select('action', 'cotes');
        return $query->getQuery()->getSingleResult();
    }
}
