<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-08-31
 * Time: 18:36
 */

namespace App\Classes\Task;


use App\Classes\Task\TaskWithCardsTemporaryInterface;
use App\Entity\Card;
use App\Entity\CardTemporary;
use App\Entity\Inspection;
use App\Entity\Marking;
use Doctrine\Common\Collections\Criteria;

/**
 * @mixin
 */
trait TaskWithCardsTemporaryTrait
{
    /**
     * @param Card $card
     * @return \App\Entity\CardTemporary|null
     */
    public function getCardTemporary(Card $card): ?CardTemporary
    {
        // Отображаем временные карточки только на этих статусах
        if (in_array($this->getStatus(), Marking::STATUS_CARD_TEMPORARY)) {
            foreach ($this->getCardsTemporary() as $cardTemporary) {
                if ($card->getId() === $cardTemporary->getCard()->getId()) {
                    return $cardTemporary;
                }
            }
        }

        return null;
    }
}