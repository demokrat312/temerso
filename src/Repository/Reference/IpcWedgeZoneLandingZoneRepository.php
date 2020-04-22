<?php

namespace App\Repository\Reference;

use App\Entity\Reference\RefIpcWedgeZoneLandingZone as IpcWedgeZoneLandingZone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IpcWedgeZoneLandingZone|null find($id, $lockMode = null, $lockVersion = null)
 * @method IpcWedgeZoneLandingZone|null findOneBy(array $criteria, array $orderBy = null)
 * @method IpcWedgeZoneLandingZone[]    findAll()
 * @method IpcWedgeZoneLandingZone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IpcWedgeZoneLandingZoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IpcWedgeZoneLandingZone::class);
    }

    // /**
    //  * @return IpcWedgeZoneLandingZone[] Returns an array of IpcWedgeZoneLandingZone objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IpcWedgeZoneLandingZone
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
