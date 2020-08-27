<?php

namespace App\Repository;

use App\Entity\OperatingTimeCounter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OperatingTimeCounter|null find($id, $lockMode = null, $lockVersion = null)
 * @method OperatingTimeCounter|null findOneBy(array $criteria, array $orderBy = null)
 * @method OperatingTimeCounter[]    findAll()
 * @method OperatingTimeCounter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperatingTimeCounterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperatingTimeCounter::class);
    }

    // /**
    //  * @return OperatingTimeCounter[] Returns an array of OperatingTimeCounter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OperatingTimeCounter
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
