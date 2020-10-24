<?php

namespace App\Repository;

use App\Entity\LogApi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LogApi|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogApi|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogApi[]    findAll()
 * @method LogApi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiApiLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogApi::class);
    }

    // /**
    //  * @return KitCard[] Returns an array of KitCard objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?KitCard
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
