<?php

namespace App\Admin;


use App\Classes\MainAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class TaskDashboardAdmin extends MainAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection
            ->add('task_create', 'task-create')
            ->add('task_list', 'task-list')
            ->add('task_list_check', 'task-list-check')
            ->add('task_list_completed', 'task-list-completed')
            ;
    }

}