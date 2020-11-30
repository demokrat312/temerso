<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-09
 * Time: 16:29
 */

namespace App\Classes\Equipment;


use App\Entity\Card;
use App\Entity\Equipment;
use App\Entity\EquipmentKit;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Trait EquipmentTrait
 * @package App\Classes\Equipment
 * @mixin Equipment
 */
trait EquipmentTrait
{
    public function getTotalCard()
    {
        $cardCount = $this->getTotalCardWithoutCatalog();

        // Если из каталога, то считаем количество карточек из каждого комплекта
//        if ($this->getWithKit() === Equipment::CATALOG_WITH) {
//            $cardCount = $this->getTotalCardWithCatalog();
//        } else {
//            $cardCount = $this->getTotalCardWithoutCatalog();
//        }

        return $cardCount;
    }

    /**
     * Считаем общее количество карточек из комплектов
     *
     * @return int
     */
    public function getTotalCardWithCatalog()
    {
        $cardCount = 0;
        $this->kits->map(function (EquipmentKit $equipmentKit) use (&$cardCount) {
            $cardCount += $this->getCardsFilterConfirmed($equipmentKit)->count();
        });

        return $cardCount;
    }

    /**
     * Выводим число введенное пользователем
     *
     * @return float|int|null
     */
    public function getTotalCardWithoutCatalog()
    {
        if ($this->getKitType() === Equipment::KIT_TYPE_SINGLE) {
            $cardCount = $this->getCardCount();
        } else {
            $cardCount = array_sum(explode(',', $this->getKitCardCount()));
        }

        return $cardCount;
    }

    public function getChoiceTitle()
    {
        return sprintf('%s. %s.',
//            $this->getId(),
            $this->getTenantName(),
//            $this->getUpdateAt()->format('Y-m-d'),
            $this->getMainReason(),
            );
    }

    /**
     * Получаем список подтвержденных карточек
     *
     * @todo Оптимизировать getTaskCardOtherFieldsByTask
     * @return Card[]|ArrayCollection
     */
    public function getCardsFilterConfirmed(EquipmentKit $kit)
    {
        $cards = new ArrayCollection();
        foreach ($kit->getCards() as $card) {
            foreach ($this->getCardsNotConfirmed() as $notConfirmed) {
                if ($card->getId() === $notConfirmed->getCard()->getId() &&
                    !$card->getTaskCardOtherFieldsByTask(
                        $kit->getEquipment()->getTaskTypeId(),
                        $kit->getEquipment()->getId())->getCommentProblemWithMark()
                ) {
                    continue 2;

                }
            }
            $cards->add($card);
        }

        return $cards;
    }

    /**
     * Получаем список не подтвержденных карточек
     *
     * @todo Оптимизировать getTaskCardOtherFieldsByTask
     * @return Card[]|ArrayCollection
     */
    public function getCardsFilterNotConfirmed(EquipmentKit $kit)
    {
        $cards = new ArrayCollection();
        foreach ($kit->getCards() as $card) {
            foreach ($this->getCardsNotConfirmed() as $notConfirmed) {
                if ($card->getId() === $notConfirmed->getCard()->getId() &&
                    !$card->getTaskCardOtherFieldsByTask(
                        $kit->getEquipment()->getTaskTypeId(),
                        $kit->getEquipment()->getId())->getCommentProblemWithMark()
                ) {
                    $cards->add($card);
                    continue 2;
                }
            }
        }


        foreach ($kit->getOver() as $over) {
            $cards->add($over);
        }

        return $cards;
    }
}