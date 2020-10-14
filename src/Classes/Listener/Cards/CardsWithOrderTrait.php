<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-10-01
 * Time: 13:56
 */

namespace App\Classes\Listener\Cards;

use App\Classes\Task\TaskItemInterface;
use App\Entity\Card;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @mixin CardsWithOrderListenerInterface
 * @see CardsWithOrderListenerHandler
 */
trait CardsWithOrderTrait
{
    /**
     * @return Collection|Card[]
     */
    public function getCards(): Collection
    {
        $cards = [];
        foreach ($this->getCardsWithOrder() as $kitCardOrder) {
            $cards[] = $kitCardOrder->getCard();
        }

        return new ArrayCollection($cards);
    }
}