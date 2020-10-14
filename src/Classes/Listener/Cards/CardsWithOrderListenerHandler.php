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

class CardsWithOrderListenerHandler
{
    public function prePersist(CardsWithOrderListenerInterface $entity)
    {
        $this->setOrderNumber($entity);
    }

    public function preUpdate(CardsWithOrderListenerInterface $entity)
    {
        $this->setOrderNumber($entity);
    }

    /**
     * @param CardsWithOrderListenerInterface $entity
     */
    protected function setOrderNumber(CardsWithOrderListenerInterface $entity): void
    {
        $indexMax = 0;
        // Находим наибольший порядковый номер, если есть
        foreach ($entity->getCardsWithOrder() as $cardWithOrder) {
            if ($cardWithOrder->getOrderNumber() > $indexMax) {
                $indexMax = $cardWithOrder->getOrderNumber();
            }
        }

        // Задаем порядковый номер для записей без номера
        foreach ($entity->getCardsWithOrder() as $cardWithOrder) {
            if (!$cardWithOrder->getOrderNumber()) {
                $cardWithOrder->setOrderNumber(++$indexMax);
            }
        }
    }
}