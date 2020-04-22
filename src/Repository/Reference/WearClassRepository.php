<?php

namespace App\Repository\Reference;

use App\Entity\Reference\RefWearClass as WearClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WearClass|null find($id, $lockMode = null, $lockVersion = null)
 * @method WearClass|null findOneBy(array $criteria, array $orderBy = null)
 * @method WearClass[]    findAll()
 * @method WearClass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WearClassRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WearClass::class);
    }

    // /**
    //  * @return WearClass[] Returns an array of WearClass objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WearClass
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
