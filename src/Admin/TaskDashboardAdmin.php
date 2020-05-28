<?php

namespace App\Admin;


use App\Classes\MainAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class TaskDashboardAdmin extends MainAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('task_create', 'task-create')
            ->add('task_list', 'task-list')
            ;
    }

}