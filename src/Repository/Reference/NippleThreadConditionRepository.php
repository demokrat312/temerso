<?php

namespace App\Repository\Reference;

use App\Entity\Reference\RefNippleThreadCondition as NippleThreadCondition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NippleThreadCondition|null find($id, $lockMode = null, $lockVersion = null)
 * @method NippleThreadCondition|null findOneBy(array $criteria, array $orderBy = null)
 * @method NippleThreadCondition[]    findAll()
 * @method NippleThreadCondition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NippleThreadConditionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NippleThreadCondition::class);
    }

    // /**
    //  * @return NippleThreadCondition[] Returns an array of NippleThreadCondition objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NippleThreadCondition
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
