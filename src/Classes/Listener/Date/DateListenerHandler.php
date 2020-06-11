<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 11.06.2020
 * Time: 08:52
 */

namespace App\Classes\Listener\Date;


use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class DateListenerHandler
{
    public function prePersist(DateListenerInterface $entity)
    {
        $entity->setCreateAt(new \DateTime('now'));
        $entity->setUpdateAt(new \DateTime('now'));
    }

    public function preUpdate(DateListenerInterface $entity)
    {
        $entity->setUpdateAt(new \DateTime('now'));
    }
}