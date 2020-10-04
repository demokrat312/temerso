<?php

namespace App\Repository;

use App\Classes\Task\TaskRepositoryParent;
use App\Entity\EquipmentCardsNotConfirmed;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method EquipmentCardsNotConfirmed|null findOneBy(array $criteria, array $orderBy = null)
 * @method EquipmentCardsNotConfirmed[]    findAll()
 * @method EquipmentCardsNotConfirmed[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipmentCardsNotConfirmedRepository extends TaskRepositoryParent
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EquipmentCardsNotConfirmed::class);
    }
}
