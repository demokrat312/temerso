<?php

namespace App\Repository\Reference;

use App\Entity\Reference\RefTypeThread as TypeThread;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeThread|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeThread|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeThread[]    findAll()
 * @method TypeThread[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeThreadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeThread::class);
    }

    // /**
    //  * @return TypeThread[] Returns an array of TypeThread objects
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
    public function findOneBySomeField($value): ?TypeThread
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
