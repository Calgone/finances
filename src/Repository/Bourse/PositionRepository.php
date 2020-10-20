<?php

namespace App\Repository\Bourse;

use App\Entity\Bourse\Position;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Position|null find($id, $lockMode = null, $lockVersion = null)
 * @method Position|null findOneBy(array $criteria, array $orderBy = null)
 * @method Position[]    findAll()
 * @method Position[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PositionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Position::class);
    }

    // /**
    //  * @return Position[] Returns an array of Position objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Position
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @param int $start
     * @param int $length
     * @param $orders
     * @param $search
     * @param $columns
     * @return array
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getRequiredDTData(int $start, int $length, $orders, $search, $columns): array
    {
        // Create Main Query
        $query = $this->createQueryBuilder('position');

        // Create Count Query
        $countQuery = $this->createQueryBuilder('position');
        $countQuery->select('COUNT(position)');

        // Create inner joins
        $query
            ->join('position.action', 'action')
            ->leftJoin('action.cotes', 'cotes')
            ->leftJoin('App\Entity\Bourse\Cote', 'last_cote',
                'WITH',
                'cotes.action=last_cote.action AND cotes.id < last_cote.id')
            ->where('last_cote.id IS NULL')
            ->select('position', 'action', 'cotes');
        $countQuery
            ->join('position.action', 'action');

        // Fields Search
        foreach ($columns as $key => $column) {
            if ($column['search']['value'] != '') {
                // $searchItem is what we are looking for
                $searchItem  = $column['search']['value'];
                $searchQuery = null;

                // $column['name'] is the name of the column as sent by the JS
                switch ($column['name']) {
                    case 'name':
                    {
                        $searchQuery = 'action.name LIKE \'%' . $searchItem . '%\'';
                        break;
                    }
                    case 'postalCode':
                    {
                        $searchQuery = 'town.postalCode LIKE \'%' . $searchItem . '%\'';
                        break;
                    }
                    case 'department':
                    {
                        $searchQuery = 'department.name LIKE \'%' . $searchItem . '%\'';
                        break;
                    }
                    case 'region':
                    {
                        $searchQuery = 'region.name LIKE \'%' . $searchItem . '%\'';
                        break;
                    }
                }

                if ($searchQuery !== null) {
                    $query->andWhere($searchQuery);
                    $countQuery->andWhere($searchQuery);
                }
            }
        }

        // Limit
        $query->setFirstResult($start)->setMaxResults($length);

        foreach ($orders as $key => $order) {
            // $order['name'] is the name of the order column as sent by the JS
            if ($order['name'] != '') {
                $orderColumn = null;

                switch ($order['name']) {
                    case 'name':
                        $orderColumn = 'town.name';
                        break;
                    case 'postalCode':
                        $orderColumn = 'town.postalCode';
                        break;
                    case 'department':
                        $orderColumn = 'department.name';
                        break;
                    case 'region':
                        $orderColumn = 'region.name';
                        break;
                }

                if ($orderColumn !== null) {
                    $query->orderBy($orderColumn, $order['dir']);
                }
            }
        }

        // Execute

        $results     = $query->getQuery()->getResult();
        $countResult = $countQuery->getQuery()->getSingleScalarResult();

        return array(
            "results"     => $results,
            "countResult" => $countResult
        );
    }
}
