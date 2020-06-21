<?php

namespace App\Repository;

use App\Classes\Task\TaskRepositoryParent;
use App\Entity\Marking;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Marking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Marking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Marking[]    findAll()
 * @method Marking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarkingRepository extends TaskRepositoryParent
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Marking::class);
    }
}
