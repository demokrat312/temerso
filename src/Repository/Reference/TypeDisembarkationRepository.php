<?php

namespace App\Repository\Reference;

use App\Entity\Reference\RefTypeDisembarkation as TypeDisembarkation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeDisembarkation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeDisembarkation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeDisembarkation[]    findAll()
 * @method TypeDisembarkation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeDisembarkationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeDisembarkation::class);
    }

    // /**
    //  * @return TypeDisembarkation[] Returns an array of TypeDisembarkation objects
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
    public function findOneBySomeField($value): ?TypeDisembarkation
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
