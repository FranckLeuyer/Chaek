<?php

namespace App\Repository;

use App\Entity\Calendar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Calendar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Calendar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Calendar[]    findAll()
 * @method Calendar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalendarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Calendar::class);
    }

    /**
     * @return Calendar[] Returns an array of Calendar objects
     */
    public function findByMonthEvents($startDate, $endDate, $userId)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.user = :userId')
            ->andWhere('c.date >= :startDate')
            ->andWhere('c.date <= :endDate')
            ->setParameter('userId', $userId)
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            // ->orderBy('c.id', 'ASC')
            // ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Calendar[] Returns an array of Calendar objects
     */
    public function findByDateJoinedToUser($startDate, $endDate)
    {
        return $this->createQueryBuilder('c')
            // ->select('COUNT(c.id)')
            ->select('u.id', 'c.badge', 'u.civility', 'u.firstName', 'u.lastName','u.email')
            ->andWhere('c.date >= :startDate')
            ->andWhere('c.date <= :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->groupBy('c.user')
            ->leftJoin('c.user', 'u')
            ->having('COUNT(c.id) = :some_count')
            ->setParameter('some_count', 3)
            ->getQuery()
            ->getResult()
        ;
    }
/*
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.date >= :startDate')
            ->andWhere('c.date <= :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->groupBy('c.user')

            ->getQuery()
            ->getResult()
        ;
    }
*/
    // /**
    //  * @return Calendar[] Returns an array of Calendar objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Calendar
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
