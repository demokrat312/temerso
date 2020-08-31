<?php

namespace App\Repository;

use App\Classes\ApiParentController;
use App\Entity\CardTemporary;
use App\Form\Data\Api\Card\CardAddToEquipmentData;
use App\Form\Data\Api\Card\CardIdentificationData;
use App\Form\Data\Api\Kit\KitData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CardTemporary|null find($id, $lockMode = null, $lockVersion = null)
 * @method CardTemporary|null findOneBy(array $criteria, array $orderBy = null)
 * @method CardTemporary[]    findAll()
 * @method CardTemporary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardTemporaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CardTemporary::class);
    }
}
