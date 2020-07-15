<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-09
 * Time: 16:29
 */

namespace App\Classes\Equipment;


use App\Entity\Equipment;
use App\Entity\EquipmentKit;

/**
 * Trait EquipmentTrait
 * @package App\Classes\Equipment
 * @mixin Equipment
 */
trait EquipmentTrait
{
    public function getTotalCard()
    {
        // Если из каталога, то считаем количество карточек из каждого комплекта
        if ($this->getWithKit() === Equipment::CATALOG_WITH) {
            $cardCount = $this->getTotalCardWithCatalog();
        } else {
            $cardCount = $this->getTotalCardWithoutCatalog();
        }

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
            $cardCount += $equipmentKit->getCards()->count();
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
}