<?php

namespace App\Admin;

use App\Classes\Task\TaskAdminParent;
use App\Classes\Task\TaskItem;
use App\Classes\Utils;
use App\Entity\CardTemporary;
use App\Entity\Inspection;
use App\Entity\Marking;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * 6) Инспекция/Дефектоскопия
 */
class InspectionAdmin extends TaskAdminParent
{
    public function configure()
    {
        $this->setTemplate('show', 'inspection/show.html.twig');
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        parent::configureShowFields($showMapper);
    }
}