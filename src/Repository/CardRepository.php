<?php

namespace App\Repository;

use App\Classes\ApiParentController;
use App\Entity\Card;
use App\Form\Data\Api\Card\CardAddToEquipmentData;
use App\Form\Data\Api\Card\CardIdentificationData;
use App\Form\Data\Api\Kit\KitData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Card|null find($id, $lockMode = null, $lockVersion = null)
 * @method Card|null findOneBy(array $criteria, array $orderBy = null)
 * @method Card[]    findAll()
 * @method Card[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Card::class);
    }

    /**
     * @param KitData $data
     * @return Card[]
     */
    public function findByKit(KitData $data)
    {
        $qb = $this->createQueryBuilder('c');
        $expr = $qb->expr();

        $rfidTagNoList = [];
        foreach ($data->getCards() as $card) {
            $rfidTagNoList[] = $card->getRfidTagNo();
        }

        $qb
            ->where($expr->in('c.rfidTagNo', ':rfidTagNo'))
            ->setParameter(':rfidTagNo', $rfidTagNoList)
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @param CardAddToEquipmentData $data
     * @return Card[]|array
     * @throws \Exception
     */
    public function findByCardAddToEquipmentType(CardAddToEquipmentData $data)
    {
        $cards = [];
        if (
            $data->getRfidTagNo() ||
            $data->getPipeSerialNumber() ||
            $data->getCouplingSerialNumber() ||
            $data->getSerialNoOfNipple()
        ) {
            $qb = $this->createQueryBuilder('c');
            $expr = $qb->expr();

            $exprAndX = [];
            if ($data->getRfidTagNo()) {
                $exprAndX[] = $expr->eq('c.rfidTagNo', ':rFidTagNo');
                $qb->setParameter('rFidTagNo', $data->getRfidTagNo());
            }
            if ($data->getPipeSerialNumber()) {
                $exprAndX[] = $expr->eq('c.pipeSerialNumber', ':pipeSerialNumber');
                $qb->setParameter('pipeSerialNumber', $data->getPipeSerialNumber());
            }
            if ($data->getCouplingSerialNumber()) {
                $exprAndX[] = $expr->eq('c.couplingSerialNumber', ':couplingSerialNumber');
                $qb->setParameter('couplingSerialNumber', $data->getCouplingSerialNumber());
            }
            if ($data->getSerialNoOfNipple()) {
                $exprAndX[] = $expr->eq('c.serialNoOfNipple', ':serialNoOfNipple');
                $qb->setParameter('serialNoOfNipple', $data->getSerialNoOfNipple());
            }

            $cards = $qb
                ->where($expr->andX(
                    ...$exprAndX
                ))
                ->getQuery()
                ->getResult();
        }

        if (count($cards) > 1) {
//            throw new \Exception('???????????????? ' . count($cards) . ' ????????????????. ???????????????? ????????????', ApiParentController::STATUS_CODE_400);
        }

//        $card = current($cards);

        if (count($cards) === 0) {
            throw new \Exception('???????????????? ???? ??????????????', ApiParentController::STATUS_CODE_404);
        }

//        return $card;
        return $cards;
    }

    /**
     * @param CardAddToEquipmentData $data
     * @return Card[]
     */
    public function findByCardIdentificationData(CardIdentificationData $data): array
    {
        if (
            $data->getRfidTagNo() ||
            $data->getPipeSerialNumber() ||
            $data->getCouplingSerialNumber() ||
            $data->getSerialNoOfNipple()
        ) {
            $qb = $this->createQueryBuilder('c');
            $expr = $qb->expr();

            $exprAndX = [];
            if ($data->getRfidTagNo()) {
                $exprAndX[] = $expr->eq('c.rfidTagNo', ':rfidTagNo');
                $qb->setParameter('rfidTagNo', $data->getRfidTagNo());
            }
            if ($data->getPipeSerialNumber()) {
                $exprAndX[] = $expr->eq('c.pipeSerialNumber', ':pipeSerialNumber');
                $qb->setParameter('pipeSerialNumber', $data->getPipeSerialNumber());
            }
            if ($data->getCouplingSerialNumber()) {
                $exprAndX[] = $expr->eq('c.couplingSerialNumber', ':couplingSerialNumber');
                $qb->setParameter('couplingSerialNumber', $data->getCouplingSerialNumber());
            }
            if ($data->getSerialNoOfNipple()) {
                $exprAndX[] = $expr->eq('c.serialNoOfNipple', ':serialNoOfNipple');
                $qb->setParameter('serialNoOfNipple', $data->getSerialNoOfNipple());
            }

            return $qb
                ->where($expr->andX(
                    ...$exprAndX
                ))
                ->getQuery()
                ->getResult();
        }

        return [];
    }

    // /**
    //  * @return Card[] Returns an array of Card objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Card
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
