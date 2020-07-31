<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-16
 * Time: 13:40
 */

namespace App\Classes\Arrival;


use App\Entity\Arrival;

/**
 * Trait ArrivalTrait
 * @package App\Classes\Arrival
 * @mixin Arrival
 */
trait ArrivalTrait
{
    public function getChoiceTitle()
    {
        return sprintf(
          '%s %s %s',
          $this->getCards()->count(), // 1)Количество единиц товара в партии
          $this->getDateArrival(), // 2)Дата приход
          $this->getNumberAndDatePurchase(), // 3)№ договора покупки, дата покупки

        );
    }
}