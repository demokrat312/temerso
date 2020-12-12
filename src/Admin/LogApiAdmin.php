<?php

namespace App\Admin;

use App\Classes\MainAdmin;
use App\Classes\ShowAdmin\ShowModeFooterActionBuilder;
use App\Classes\ShowAdmin\ShowModeFooterButtonItem;
use App\Controller\Admin\MarkingAdminController;
use App\Entity\Arrival;
use App\Entity\Card;
use App\Entity\Marking;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class LogApiAdmin extends MainAdmin
{

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection
            ->remove('export')
            ->remove('acl')
        ;
    }

    protected function configureDefaultFilterValues(array &$filterValues)
    {
        $filterValues = [
            '_sort_by' => 'id',
            '_sort_order' => 'DESC',
        ];
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('id')
            ->add('createdBy')
            ->add('createAt')
            ->add('ip')
            ->add('url')
            ->add('requestContentDecode', null, ['template' => 'crud/list/json.field.html.twig'])
            ->add('responseContentDecode', null, ['template' => 'crud/list/json.field.html.twig'])
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('createdBy')
            ->add('createAt')
            ->add('ip')
            ->add('url')
            ->add('requestContent')
        ;
    }

    protected function configureFormFields(FormMapper $form)
    {

    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
    }

}