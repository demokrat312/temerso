<?php

namespace App\Repository;

use App\Classes\Task\TaskRepositoryParent;
use App\Entity\Inspection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Inspection|null find($id, $lockMode = null, $lockVersion = null)
 * @method Inspection|null findOneBy(array $criteria, array $orderBy = null)
 * @method Inspection[]    findAll()
 * @method Inspection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InspectionRepository extends TaskRepositoryParent
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inspection::class);
    }
}
