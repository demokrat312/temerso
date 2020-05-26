<?php
/**
 * Created by PhpStorm.
 * User: back
 * Date: 19.05.2020
 * Time: 14:00
 */

namespace App\EventListener;


use App\Classes\DateListenerInterface;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class DateListener
{
    public function prePersist(DateListenerInterface $entity, LifecycleEventArgs $event)
    {
        $entity->setCreateAt(new \DateTime('now'));
        $entity->setUpdateAt(new \DateTime('now'));
    }

    public function preUpdate(DateListenerInterface $entity, LifecycleEventArgs $event)
    {
        $entity->setUpdateAt(new \DateTime('now'));
    }
}