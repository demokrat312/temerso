<?php

namespace App\Repository\Reference;

use App\Entity\Reference\RefHardbandingNippleState as HardbendigNippleState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HardbendigNippleState|null find($id, $lockMode = null, $lockVersion = null)
 * @method HardbendigNippleState|null findOneBy(array $criteria, array $orderBy = null)
 * @method HardbendigNippleState[]    findAll()
 * @method HardbendigNippleState[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HardbendigNippleStateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HardbendigNippleState::class);
    }

    // /**
    //  * @return HardbendigNippleState[] Returns an array of HardbendigNippleState objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HardbendigNippleState
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
