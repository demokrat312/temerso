<?php

namespace App\Repository;

use App\Entity\KitCardOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KitCardOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method KitCardOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method KitCardOrder[]    findAll()
 * @method KitCardOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KitCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KitCardOrder::class);
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
