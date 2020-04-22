<?php

namespace App\Repository\Reference;

use App\Entity\Reference\RefPipeBodyClass as PipeBodyClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PipeBodyClass|null find($id, $lockMode = null, $lockVersion = null)
 * @method PipeBodyClass|null findOneBy(array $criteria, array $orderBy = null)
 * @method PipeBodyClass[]    findAll()
 * @method PipeBodyClass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PipeBodyClassRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PipeBodyClass::class);
    }

    // /**
    //  * @return PipeBodyClass[] Returns an array of PipeBodyClass objects
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
    public function findOneBySomeField($value): ?PipeBodyClass
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
