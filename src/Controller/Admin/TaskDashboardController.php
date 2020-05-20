<?php

namespace App\Controller\Admin;


use App\Classes\Dashboard\DashboardTask;
use Sonata\AdminBundle\Action\DashboardAction;
use Sonata\AdminBundle\Controller\CRUDController;

class TaskDashboardController extends CRUDController
{
    /**
     * @var DashboardAction
     */
    private $dashboard;

    public function __construct( DashboardAction $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    public function listAction()
    {
        $dashboardRef = new DashboardTask();
        $dashboardRef->changeBlocks($this->dashboard);

        return $this->dashboard->__invoke($this->getRequest());
    }

}