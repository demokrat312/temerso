<?php

namespace App\Admin;

use App\Classes\Task\TaskAdminParent;

/**
 * 6) Инспекция/Дефектоскопия
 */
class InspectionAdmin extends TaskAdminParent
{
    public function configure()
    {
        $this->setTemplate('show', 'inspection/show.html.twig');
    }


}