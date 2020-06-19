<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 19.06.2020
 * Time: 11:49
 */

namespace App\Classes\Marking;

use App\Entity\Card;

/**
 * Карточки из маркировки приводем к карточкам для задачи
 */
class MarkingCardToTaskCardAdapter
{
    public function getCard(Card $card)
    {
        $taskCard = new MarkingTaskCard();

        $taskCard
            ->setId($card->getId())
            ->setFullName($card->getGeneralName())
            ->setPipeSerialNumber($card->getPipeSerialNumber())
            ->setSerialNoOfNipple($card->getSerialNoOfNipple())
            ->setCouplingSerialNumber($card->getCouplingSerialNumber())
            ->setRfidTagSerialNo($card->getRfidTagSerialNo())
            ->setComment('')
            ;

        return $taskCard;
    }
}