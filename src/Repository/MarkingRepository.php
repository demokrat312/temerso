<?php

namespace App\Repository;

use App\Entity\Marking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Marking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Marking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Marking[]    findAll()
 * @method Marking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarkingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Marking::class);
    }

    // /**
    //  * @return Marking[] Returns an array of Marking objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Marking
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
