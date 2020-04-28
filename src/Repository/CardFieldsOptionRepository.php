<?php

namespace App\Repository;

use App\Entity\CardFieldsOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CardFieldsOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method CardFieldsOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method CardFieldsOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardFieldsOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CardFieldsOption::class);
    }

    public function findAll() {
        return $this->createQueryBuilder('o', 'o.id')->getQuery()->getResult();
    }

    // /**
    //  * @return CardFieldsOption[] Returns an array of CardFieldsOption objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CardFieldsOption
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
