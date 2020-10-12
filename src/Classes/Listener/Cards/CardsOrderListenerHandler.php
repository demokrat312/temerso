<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 11.06.2020
 * Time: 08:52
 */

namespace App\Classes\Listener\Cards;


use App\Classes\Listener\Date\DateListenerInterface;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class CardsOrderListenerHandler
{
    public function prePersist(CardsOrderListenerInterface $entity)
    {
        if ($entity->getCards() && $entity->getCards()->count() > 0 && !$entity->getCardsOrder()) {
            $index = 0;
            $cardsOrder = [];
            foreach ($entity->getCards() as $card) {
                $cardsOrder[] = [
                    'cardId' => $card->getId(),
                    'index' => $index++
                ];
            }

            $entity->setCardsOrder($cardsOrder);
        }
    }


}