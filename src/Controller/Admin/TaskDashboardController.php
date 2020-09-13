<?php

namespace App\Controller\Admin;


use App\Classes\Dashboard\DashboardTask;
use App\Classes\Task\TaskMenuBuilder;
use App\Entity\Marking;
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
            'taskList' => $builder->buildList(),
            'title' => 'Задания'
        ]);
    }

    /**
     * Задания ожидающие проверку
     */
    public function taskListCheckAction(AdminRouteService $adminRoute) {
        $builder = new TaskMenuBuilder($adminRoute);
        $blockList = $builder->buildList() ;
        foreach ($blockList as $block) {
            // Добавляем фильтрацию по статусу
            $block->setRoute($block->getRoute() . '?status=' . Marking::STATUS_SAVE . '&filter[status]=' . Marking::STATUS_SAVE);
        }
        return $this->renderWithExtraParams('task/list.html.twig', [
            'taskList' => $blockList,
            'title' => 'Задания, ожидающие проверку'
        ]);
    }

    /**
     * Задания Выполненые полностью
     */
    public function taskListCompletedAction(AdminRouteService $adminRoute) {
        $builder = new TaskMenuBuilder($adminRoute);
        $blockList = $builder->buildList() ;
        foreach ($blockList as $block) {
            // Добавляем фильтрацию по статусу
            $block->setRoute($block->getRoute() . '?status=' . Marking::STATUS_COMPLETE . '&filter[status]=' . Marking::STATUS_COMPLETE);
        }
        return $this->renderWithExtraParams('task/list.html.twig', [
            'taskList' => $blockList,
            'title' => 'Задания, выполненые полностью'
        ]);
    }

}