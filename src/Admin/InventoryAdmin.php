<?php

namespace App\Admin;

use App\Classes\Task\TaskAdminParent;

/**
 * Инвентаризация
 */
class InventoryAdmin extends TaskAdminParent
{
    public function configure()
    {
        $this->setTemplate('show', 'inventory/show.html.twig');
    }
}