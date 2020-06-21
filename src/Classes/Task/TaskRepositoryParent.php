<?php

namespace App\Classes\Task;

use App\Classes\Marking\MarkingAccessHelper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;

abstract class TaskRepositoryParent extends ServiceEntityRepository
{
    /**
     * Получаем список задач по пользоветлю
     */
    public function findAllTask(int $userId)
    {
        $qb = $this->createQueryBuilder('m');

        $this->byAccess($userId, $qb);

        return $qb
            ->getQuery()
            ->getResult();
    }

    /**
     * Получаем список задач по пользователю
     */
    public function findTask(int $taskId, int $userId)
    {
        $qb = $this->createQueryBuilder('m');

        // Добавляем выборку карточек сразу при основном запросе
        $qb->addSelect('cards');
        $qb->join('m.cards', 'cards');

        $qb
            ->where('m.id = :taskId')
            ->setParameter('taskId', $taskId);

        $this->byAccess($userId, $qb);

        return $qb
            ->getQuery()
            ->getOneOrNullResult();
    }

    private function byAccess(int $userId, QueryBuilder $qb)
    {
        $expr = $qb->expr();

        $qb->setParameter('userId', $userId);

        // По доступам для постановщика(адимина)
        $creatorExpr = $expr->andX(
            $expr->eq('m.createdBy', ':userId'),
            $expr->in('m.status', ':createdByStatusIds')
        );
        $qb
            ->setParameter('createdByStatusIds', MarkingAccessHelper::getShowStatusAccess(MarkingAccessHelper::USER_TYPE_CREATOR));
        // По доступам для исполнителя(кладовщик)
        $qb->leftJoin('m.users', 'users');
        $executorExpr = $expr->andX(
            $expr->eq('users.id', ':userId'),
            $expr->in('m.status', ':executorStatusIds')
        );
        $qb
            ->setParameter('executorStatusIds', MarkingAccessHelper::getShowStatusAccess(MarkingAccessHelper::USER_TYPE_EXECUTOR));

        $qb->andWhere($expr->orX($creatorExpr, $executorExpr));

        return $qb;
    }
}