<?php

namespace App\Repository\Reference;

use App\Entity\Reference\RefThreadCoating as ThreadCoating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ThreadCoating|null find($id, $lockMode = null, $lockVersion = null)
 * @method ThreadCoating|null findOneBy(array $criteria, array $orderBy = null)
 * @method ThreadCoating[]    findAll()
 * @method ThreadCoating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThreadCoatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ThreadCoating::class);
    }

    // /**
    //  * @return ThreadCoating[] Returns an array of ThreadCoating objects
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
    public function findOneBySomeField($value): ?ThreadCoating
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
