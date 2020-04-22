<?php

namespace App\Repository\Reference;

use App\Entity\Reference\RefVisualControl as VisualControl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VisualControl|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisualControl|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisualControl[]    findAll()
 * @method VisualControl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisualControlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisualControl::class);
    }

    // /**
    //  * @return VisualControl[] Returns an array of VisualControl objects
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
    public function findOneBySomeField($value): ?VisualControl
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
