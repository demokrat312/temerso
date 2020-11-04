<?php

namespace App\Repository;

use App\Classes\Task\TaskRepositoryParent;
use App\Entity\Equipment;
use App\Entity\Marking;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method Equipment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Equipment[]    findAll()
 * @method Equipment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipmentRepository extends TaskRepositoryParent
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equipment::class);
    }

    /**
     * @param mixed $id
     * @param null $lockMode
     * @param null $lockVersion
     * @return Equipment|object
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        $equipment = parent::find($id);
        if (!$equipment) throw new NotFoundHttpException('Задача с id: ' . (is_array($id) ? current($id) : $id) . " не найдена");

        return $equipment;
    }

    protected function taskCardJoin(QueryBuilder $qb)
    {
//        $al = $qb->getRootAliases()[0];
//
//        $qb->addSelect('cards', 'kits');
//        $qb
//            ->leftJoin(sprintf('%s.%s', $al, 'kits'), 'kits')
//            ->leftJoin('kits.card', 'card')
//        ;
    }

    /**
     * Не отображаем те которые вернулись из аренды
     */
    public function withOutReturnFromRent()
    {
        $qb = $this->createQueryBuilder('equipment');
        $expr = $qb->expr();

        return $qb
            ->leftJoin('equipment.returnFromRent', 'rent')
            ->where($expr->andX(
                $expr->isNull('rent.id'), // Не отображаем те которые уже возвращены
                $expr->eq('equipment.status', ':status'), // Отображаем только завершенные задачи
            ))
            ->setParameter('status', Marking::STATUS_COMPLETE)
            ->orderBy('equipment.id', 'DESC');
    }


}
