<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-10-23
 * Time: 23:14
 */

namespace App\Classes\Inventory;

use App\Entity\Inventory;

/**
 * @mixin Inventory
 */
trait InventoryTrait
{
    /**
     * Недостача
     */
    public function deficitCount()
    {
        $count = 0;
        foreach ($this->getCardsTemporary() as $cardTemporary) {
            if($cardTemporary->getAccounting() === false)$count++;
        }

        return $count;
    }

    /**
     * Итого по факту
     */
    public function totalInFact()
    {
        return $this->getCards()->count()
            - $this->deficitCount()
            + $this->getOver()->count();
    }
}