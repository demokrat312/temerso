<?php

namespace App\Controller\Admin;


use App\Classes\Dashboard\DashboardTask;
use App\Classes\Task\TaskMenuBuilder;
use App\Service\AdminRouteService;
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

    public function taskCreateAction(AdminRouteService $adminRoute) {
        $builder = new TaskMenuBuilder($adminRoute);
        return $this->renderWithExtraParams('task/create.html.twig', [
            'taskList' => $builder->buildCreate()
        ]);
    }

    public function taskListAction(AdminRouteService $adminRoute) {
        $builder = new TaskMenuBuilder($adminRoute);
        return $this->renderWithExtraParams('task/list.html.twig', [
            'taskList' => $builder->buildList()
        ]);
    }

}