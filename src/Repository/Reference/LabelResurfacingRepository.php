<?php

namespace App\Repository\Reference;

use App\Entity\Reference\RefLabelResurfacing as LabelResurfacing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LabelResurfacing|null find($id, $lockMode = null, $lockVersion = null)
 * @method LabelResurfacing|null findOneBy(array $criteria, array $orderBy = null)
 * @method LabelResurfacing[]    findAll()
 * @method LabelResurfacing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LabelResurfacingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LabelResurfacing::class);
    }

    // /**
    //  * @return LabelResurfacing[] Returns an array of LabelResurfacing objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LabelResurfacing
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
