<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 11.06.2020
 * Time: 08:53
 */

namespace App\EventListener;


use App\Classes\Listener\Cards\CardsOrderListenerHandler;
use App\Classes\Listener\Cards\CardsOrderListenerInterface;
use App\Classes\Listener\Cards\CardsWithOrderListenerHandler;
use App\Classes\Listener\Cards\CardsWithOrderListenerInterface;
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
    /**
     * @var CardsOrderListenerHandler
     */
    private $cardsOrderListenerHandler;
    /**
     * @var CardsWithOrderListenerHandler
     */
    private $cardsWithOrderListenerHandler;

    public function __construct(Security $security)
    {
        $this->dateListener = new DateListenerHandler();
        $this->createdByListener = new CreatedByListenerHandler($security);
        $this->cardsOrderListenerHandler = new CardsOrderListenerHandler();
        $this->cardsWithOrderListenerHandler = new CardsWithOrderListenerHandler();
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
        if ($entity instanceof CardsOrderListenerInterface) {
            $this->cardsOrderListenerHandler->prePersist($entity);
        }
        if ($entity instanceof CardsWithOrderListenerInterface) {
            $this->cardsWithOrderListenerHandler->prePersist($entity);
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof DateListenerInterface) {
            $this->dateListener->preUpdate($entity);
        }
        if ($entity instanceof CardsWithOrderListenerInterface) {
            $this->cardsWithOrderListenerHandler->preUpdate($entity);
        }
    }
}