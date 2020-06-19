<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 28.05.2020
 * Time: 10:25
 */

namespace App\Classes\Task;


use App\Entity\Marking;
use App\Service\AdminRouteService;

class TaskMenuBuilder
{
    /**
     * @var AdminRouteService
     */
    private $adminRoute;

    public function __construct(AdminRouteService $adminRoute)
    {
        $this->adminRoute = $adminRoute;
    }


    /**
     * @return array|TaskMenuItem[]
     */
    public function buildCreate()
    {
        return [
            (new TaskMenuItem())
                ->setTitle('Маркировка')
                ->setRoute($this->adminRoute->getActionRoute(Marking::class, 'create'))
                ->setRouteTitle('link_action_create')
            ,
            (new TaskMenuItem())
                ->setTitle('Инверторизация')
                ->setRoute($this->adminRoute->getRoute('admin_empty'))
                ->setRouteTitle('link_action_create')
            ,
            (new TaskMenuItem())
                ->setTitle('Инспекция')
                ->setRoute($this->adminRoute->getRoute('admin_empty'))
                ->setRouteTitle('link_action_create')
            ,
            (new TaskMenuItem())
                ->setTitle('Комплектация в аренду')
                ->setRoute($this->adminRoute->getRoute('admin_empty'))
                ->setRouteTitle('link_action_create')
            ,
            (new TaskMenuItem())
                ->setTitle('Возврат из аренды')
                ->setRoute($this->adminRoute->getRoute('admin_empty'))
                ->setRouteTitle('link_action_create')
            ,
            (new TaskMenuItem())
                ->setTitle('Комплектация в ремонт')
                ->setRoute($this->adminRoute->getRoute('admin_empty'))
                ->setRouteTitle('link_action_create')
            ,
            (new TaskMenuItem())
                ->setTitle('Возврат из ремонта')
                ->setRoute($this->adminRoute->getRoute('admin_empty'))
                ->setRouteTitle('link_action_create')
            ,
        ];
    }


    /**
     * @return array|TaskMenuItem[]
     */
    public function buildList()
    {
        return [
            (new TaskMenuItem())
                ->setTitle('Маркировка')
                ->setRoute($this->adminRoute->getActionRoute(Marking::class, 'list'))
                ->setRouteTitle('link_list')
            ,
            (new TaskMenuItem())
                ->setTitle('Инверторизация')
                ->setRoute($this->adminRoute->getRoute('admin_empty'))
                ->setRouteTitle('link_list')
            ,
            (new TaskMenuItem())
                ->setTitle('Инспекция')
                ->setRoute($this->adminRoute->getRoute('admin_empty'))
                ->setRouteTitle('link_list')
            ,
            (new TaskMenuItem())
                ->setTitle('Комплектация в аренду')
                ->setRoute($this->adminRoute->getRoute('admin_empty'))
                ->setRouteTitle('link_list')
            ,
            (new TaskMenuItem())
                ->setTitle('Возврат из аренды')
                ->setRoute($this->adminRoute->getRoute('admin_empty'))
                ->setRouteTitle('link_list')
            ,
            (new TaskMenuItem())
                ->setTitle('Комплектация в ремонт')
                ->setRoute($this->adminRoute->getRoute('admin_empty'))
                ->setRouteTitle('link_list')
            ,
            (new TaskMenuItem())
                ->setTitle('Возврат из ремонта')
                ->setRoute($this->adminRoute->getRoute('admin_empty'))
                ->setRouteTitle('link_list')
            ,
        ];
    }
}