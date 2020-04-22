<?php

namespace App\Repository\Reference;

use App\Entity\Reference\RefStatePersistent as StatePersistent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StatePersistent|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatePersistent|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatePersistent[]    findAll()
 * @method StatePersistent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatePersistentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatePersistent::class);
    }

    // /**
    //  * @return StatePersistent[] Returns an array of StatePersistent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StatePersistent
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
