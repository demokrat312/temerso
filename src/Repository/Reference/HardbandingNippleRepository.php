<?php

namespace App\Repository\Reference;

use App\Entity\Reference\RefHardbandingNipple as HardbandingNipple;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HardbandingNipple|null find($id, $lockMode = null, $lockVersion = null)
 * @method HardbandingNipple|null findOneBy(array $criteria, array $orderBy = null)
 * @method HardbandingNipple[]    findAll()
 * @method HardbandingNipple[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HardbandingNippleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HardbandingNipple::class);
    }

    // /**
    //  * @return HardbandingNipple[] Returns an array of HardbandingNipple objects
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
    public function findOneBySomeField($value): ?HardbandingNipple
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
