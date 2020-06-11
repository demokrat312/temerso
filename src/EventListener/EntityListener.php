<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 11.06.2020
 * Time: 08:53
 */

namespace App\EventListener;


use App\Classes\Listener\CreatedBy\CreatedByListenerHandler;
use App\Classes\Listener\CreatedBy\CreatedByListenerInterface;
use App\Classes\Listener\Date\DateListenerHandler;
use App\Classes\Listener\Date\DateListenerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

class EntityListener
{
    /**
     * @var DateListenerHandler
     */
    private $dateListener;
    /**
     * @var CreatedByListenerHandler
     */
    private $createdByListener;

    public function __construct(Security $security)
    {
        $this->dateListener = new DateListenerHandler();
        $this->createdByListener = new CreatedByListenerHandler($security);
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof DateListenerInterface) {
            $this->dateListener->prePersist($entity);
        }
        if ($entity instanceof CreatedByListenerInterface) {
            $this->createdByListener->prePersist($entity);
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof DateListenerInterface) {
            $this->dateListener->preUpdate($entity);
        }
    }
}