<?php

namespace App\Admin;

use App\Classes\Task\TaskAdminParent;
use App\Entity\Inventory;

/**
 * Инвентаризация
 */
class InventoryAdmin extends TaskAdminParent
{
    public function configure()
    {
        $this->setTemplate('show', 'inventory/show.html.twig');
    }

    /**
     * После создания задачи
     * @var Inventory $object
     */
    public function postPersist($object)
    {
        $em = $this->getEntityManager();
        foreach ($object->getCards() as $card) {
            $card->setAccounting(0);
            $em->persist($card);
        }

        $em->flush();
    }
}