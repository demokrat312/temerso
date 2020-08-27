<?php

namespace App\Repository;

use App\Entity\Card;
use App\Entity\ReturnFromRent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReturnFromRent|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReturnFromRent|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReturnFromRent[]    findAll()
 * @method ReturnFromRent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReturnFromRentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReturnFromRent::class);
    }

    public function getCards(int $id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb
            ->select('card')
            ->from(Card::class, 'card')

            ->join('card.equipmentKit', 'equipmentKit')
            ->join('equipmentKit.equipment', 'equipment')
            ->join('equipment.returnFromRent', 'returnFromRent')

            ->where('returnFromRent.id = :id')
            ->setParameter('id', $id)
        ;

        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return ReturnFromRent[] Returns an array of ReturnFromRent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReturnFromRent
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
