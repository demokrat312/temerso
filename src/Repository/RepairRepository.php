<?php

namespace App\Repository;

use App\Classes\Task\TaskRepositoryParent;
use App\Entity\Marking;
use App\Entity\Repair;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Repair|null find($id, $lockMode = null, $lockVersion = null)
 * @method Repair|null findOneBy(array $criteria, array $orderBy = null)
 * @method Repair[]    findAll()
 * @method Repair[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepairRepository extends TaskRepositoryParent
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Repair::class);
    }

    /**
     * Не отображаем те которые вернулись из ремонта
     */
    public function withOutReturnFromRepair()
    {
        $qb = $this->createQueryBuilder('repair');
        $expr = $qb->expr();

        return $qb
            ->leftJoin('repair.returnFromRepair', 'returnFromRepair')
            ->where($expr->andX(
                $expr->isNull('returnFromRepair.id'), // Не отображаем те которые уже возвращены
                $expr->eq('repair.status', Marking::STATUS_COMPLETE), // Отображаем только завершенные задачи
            ))
//            ->setParameter('returnFromRepairStatus', Marking::STATUS_COMPLETE)
            ->where('returnFromRepair.id is null')// Не отображаем те которые уже возвращены
            ->orderBy('repair.id', 'DESC');
    }

    // /**
    //  * @return Repair[] Returns an array of Repair objects
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
    public function findOneBySomeField($value): ?Repair
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
