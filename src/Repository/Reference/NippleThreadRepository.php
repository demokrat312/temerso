<?php

namespace App\Repository\Reference;

use App\Entity\Reference\RefNippleThread as NippleThread;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NippleThread|null find($id, $lockMode = null, $lockVersion = null)
 * @method NippleThread|null findOneBy(array $criteria, array $orderBy = null)
 * @method NippleThread[]    findAll()
 * @method NippleThread[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NippleThreadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NippleThread::class);
    }

    // /**
    //  * @return NippleThread[] Returns an array of NippleThread objects
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
    public function findOneBySomeField($value): ?NippleThread
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
