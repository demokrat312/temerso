<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 23.05.2020
 * Time: 22:06
 */

namespace App\Classes\Listener\Cards;


use App\Entity\Card;
use Doctrine\Common\Collections\Collection;

interface CardsWithOrderListenerInterface
{
    public function addCard(Card $card);
    /** @return Card[] */
    public function getCards(): Collection;

    /** @return CardWithOrderInterface[] */
    public function getCardsWithOrder(): Collection;
}