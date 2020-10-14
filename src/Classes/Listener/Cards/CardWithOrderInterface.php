<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-10-14
 * Time: 15:18
 */

namespace App\Classes\Listener\Cards;


use App\Entity\Card;

interface CardWithOrderInterface
{
    public function setCard(Card $card);
    public function getOrderNumber();
    public function setOrderNumber($orderNumber);
}