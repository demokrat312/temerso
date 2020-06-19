<?php

namespace App\Repository;

use App\Classes\Marking\MarkingAccess;
use App\Entity\Marking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Marking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Marking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Marking[]    findAll()
 * @method Marking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarkingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Marking::class);
    }

    /**
     *
     */
    public function findTask(int $userId)
    {
        $qb = $this->createQueryBuilder('m');
        $expr = $qb->expr();

        $qb->setParameter('userId', $userId);

        // По доступам для постановщика(адимина)
        $creatorExpr = $expr->andX(
            $expr->eq('m.createdBy', ':userId'),
            $expr->in('m.status', ':createdByStatusIds')
        );
        $qb
            ->setParameter('createdByStatusIds', MarkingAccess::getShowStatusAccess(MarkingAccess::USER_TYPE_CREATOR))
        ;
        // По доступам для исполнителя(кладовщик)
        $qb->leftJoin('m.users', 'users');
        $executorExpr = $expr->andX(
            $expr->eq('users.id', ':userId'),
            $expr->in('m.status', ':executorStatusIds')
        );
        $qb
            ->setParameter('executorStatusIds', MarkingAccess::getShowStatusAccess(MarkingAccess::USER_TYPE_EXECUTOR))
        ;

        return $qb
            ->where($expr->orX($creatorExpr, $executorExpr))
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Marking[] Returns an array of Marking objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Marking
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
