<?php

namespace App\Repository;

use App\Entity\EquipmentKit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EquipmentKit|null find($id, $lockMode = null, $lockVersion = null)
 * @method EquipmentKit|null findOneBy(array $criteria, array $orderBy = null)
 * @method EquipmentKit[]    findAll()
 * @method EquipmentKit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipmentKitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EquipmentKit::class);
    }

    // /**
    //  * @return EquipmentKit[] Returns an array of EquipmentKit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EquipmentKit
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
