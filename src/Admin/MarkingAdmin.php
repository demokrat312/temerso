<?php

namespace App\Admin;

use App\Classes\Task\TaskAdminParent;

/**
 * Маркировка
 */
class MarkingAdmin extends TaskAdminParent
{
    public function configure()
    {
        $this->setTemplate('show', 'marking/show.html.twig');
    }
}