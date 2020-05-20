<?php

namespace App\Admin;

use App\Classes\MainAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Маркировка
 */
class MarkingAdmin extends MainAdmin
{

    protected function configureListFields(ListMapper $list)
    {
        $list->add('id');
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('general', ['label' => 'Главная', 'class' => 'col-md-12'])
                ->add('cards')
                ->add('users')
            ->end()
        ;
    }

    protected function configureFormFields(FormMapper $editForm)
    {
         $editForm
            ->with('general', ['label' => 'Главная', 'class' => 'col-md-12'])
                ->add('cards')
                ->add('users')
            ->end()
        ;
    }
}