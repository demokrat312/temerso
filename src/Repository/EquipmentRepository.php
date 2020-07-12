<?php

namespace App\Repository;

use App\Classes\Task\TaskRepositoryParent;
use App\Entity\Equipment;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Equipment|null find($id, $lockMode = null, $lockVersion = null)
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


}
