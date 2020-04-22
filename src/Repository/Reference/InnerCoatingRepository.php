<?php

namespace App\Repository\Reference;

use App\Entity\Reference\RefInnerCoating as InnerCoating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InnerCoating|null find($id, $lockMode = null, $lockVersion = null)
 * @method InnerCoating|null findOneBy(array $criteria, array $orderBy = null)
 * @method InnerCoating[]    findAll()
 * @method InnerCoating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InnerCoatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InnerCoating::class);
    }

    // /**
    //  * @return InnerCoating[] Returns an array of InnerCoating objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InnerCoating
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
