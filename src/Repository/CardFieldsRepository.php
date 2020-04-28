<?php

namespace App\Repository;

use App\Entity\CardFields;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CardFields|null find($id, $lockMode = null, $lockVersion = null)
 * @method CardFields|null findOneBy(array $criteria, array $orderBy = null)
 * @method CardFields[]    findAll()
 * @method CardFields[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardFieldsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CardFields::class);
    }

    // /**
    //  * @return CardFields[] Returns an array of CardFields objects
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
    public function findOneBySomeField($value): ?CardFields
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
