<?php

namespace App\Repository\Reference;

use App\Entity\Reference\RefPipeStrengthGroup as PipeStrengthGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PipeStrengthGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method PipeStrengthGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method PipeStrengthGroup[]    findAll()
 * @method PipeStrengthGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PipeStrengthGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PipeStrengthGroup::class);
    }

    // /**
    //  * @return PipeStrengthGroup[] Returns an array of PipeStrengthGroup objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PipeStrengthGroup
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
