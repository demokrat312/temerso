<?php

namespace App\Repository;

use App\Classes\ApiParentController;
use App\Entity\Card;
use App\Form\Data\Api\Card\CardAddToEquipmentData;
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
     * @return Card|null
     * @throws \Exception
     */
    public function findByCardAddToEquipmentType(CardAddToEquipmentData $data): Card
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
                $exprAndX[] = $expr->eq('c.rfidTagNo', $data->getRfidTagNo());
            }
            if ($data->getPipeSerialNumber()) {
                $exprAndX[] = $expr->eq('c.pipeSerialNumber', $data->getPipeSerialNumber());
            }
            if ($data->getCouplingSerialNumber()) {
                $exprAndX[] = $expr->eq('c.couplingSerialNumber', $data->getCouplingSerialNumber());
            }
            if ($data->getSerialNoOfNipple()) {
                $exprAndX[] = $expr->eq('c.serialNoOfNipple', $data->getSerialNoOfNipple());
            }

            $cards = $qb
                ->where($expr->andX(
                    ...$exprAndX
                ))
                ->getQuery()
                ->getResult();
        }

        if (count($cards) > 1) {
            throw new \Exception('Найденно ' . count($cards) . ' карточки. Уточните запрос', ApiParentController::STATUS_CODE_400);
        }

        $card = current($cards);

        if (empty($card)) {
            throw new \Exception('Карточка не найдена', ApiParentController::STATUS_CODE_404);
        }

        return $card;
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
