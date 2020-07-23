<?php

namespace App\Repository;

use App\Entity\InventoryOver;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InventoryOver|null find($id, $lockMode = null, $lockVersion = null)
 * @method InventoryOver|null findOneBy(array $criteria, array $orderBy = null)
 * @method InventoryOver[]    findAll()
 * @method InventoryOver[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InventoryOverRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InventoryOver::class);
    }

    // /**
    //  * @return InventoryOver[] Returns an array of InventoryOver objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InventoryOver
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
