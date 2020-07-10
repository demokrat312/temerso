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
        $cardCount = 0;
        // Если из каталога, то считаем количество карточек из каждого комплекта
        if ($this->getWithKit() === Equipment::CATALOG_WITH) {
            $this->kits->map(function (EquipmentKit $equipmentKit) use (&$cardCount) {
                $cardCount += $equipmentKit->getCard()->count();
            });
        } else {
            if($this->getKitType() === Equipment::KIT_TYPE_SINGLE) {
                $cardCount = $this->getCardCount();
            } else {
                $cardCount = array_sum(explode(',', $this->getKitCardCount()));
            }
        }

        return $cardCount;
    }
}