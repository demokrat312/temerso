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
 * @mixin CardsOrderListenerInterface
 * @see CardsOrderListenerHandler
 */
trait CardsOrderTrait
{
    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $cardsOrder;

    public function getCardsOrder(): ?array
    {
        return $this->cardsOrder;
    }

    public function setCardsOrder(array $cardsOrder)
    {
        $this->cardsOrder = $cardsOrder;
    }

    public function getCardsWithOrder(): Collection
    {
        if ($this->getCardsOrder()) {
            $cardsOrder = [];
            foreach ($this->cards as $card) {
                /** @var Card $card */
                foreach ($this->getCardsOrder() as $orderItem) {
                    if ($orderItem['cardId'] === $card->getId()) {
                        $cardsOrder[$orderItem['index']] = $card;
                        continue 2;
                    }
                }
            }

            ksort($cardsOrder);
            return new ArrayCollection($cardsOrder);
        }

        return $this->cards;
    }
}