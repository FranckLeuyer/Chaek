<?php

namespace App\Repository;

use App\Entity\PrestationObject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PrestationObject|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrestationObject|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrestationObject[]    findAll()
 * @method PrestationObject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrestationObjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrestationObject::class);
    }

    // /**
    //  * @return PrestationObject[] Returns an array of PrestationObject objects
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
    public function findOneBySomeField($value): ?PrestationObject
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
