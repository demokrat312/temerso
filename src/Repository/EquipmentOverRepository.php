<?php

namespace App\Repository;

use App\Entity\EquipmentOver;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EquipmentOver|null find($id, $lockMode = null, $lockVersion = null)
 * @method EquipmentOver|null findOneBy(array $criteria, array $orderBy = null)
 * @method EquipmentOver[]    findAll()
 * @method EquipmentOver[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipmentOverRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EquipmentOver::class);
    }

    // /**
    //  * @return EquipmentOver[] Returns an array of EquipmentOver objects
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
    public function findOneBySomeField($value): ?EquipmentOver
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
