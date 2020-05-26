<?php

namespace App\Admin;

use App\Classes\MainAdmin;
use App\Classes\ShowAdmin\ShowModeFooterActionBuilder;
use App\Classes\ShowAdmin\ShowModeFooterButtonItem;
use App\Controller\Admin\MarkingAdminController;
use App\Entity\Card;
use App\Entity\Marking;
use App\Form\Type\AdminListType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Маркировка
 */
class MarkingAdmin extends MainAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add(MarkingAdminController::ROUTER_CHANGE_STATUS, $this->getRouterIdParameter() . '/change-status');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('id');
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('general', ['label' => 'Главная', 'class' => 'col-md-12'])
            ->add('users')
            ->add('cards')
            ->end();
    }

    protected function configureFormFields(FormMapper $editForm)
    {
        $editForm
            ->with('general', ['label' => 'Главная', 'class' => 'col-md-12'])
            ->add('cards', AdminListType::class, [
                'class' => Card::class,
                'field_show_name' => 'generalName',
                'multiple' => true,
                'label' => 'Карточки',
            ])
            ->add('users', \Sonata\AdminBundle\Form\Type\ModelAutocompleteType::class, [
                'property' => 'all',
                'multiple' => true,
                'label' => 'Исполнители',
            ])
            ->end();


        $actionButtons = new ShowModeFooterActionBuilder();

        if ($this->isCurrentRoute('create')) {
            $actionButtons->addItem($actionButtons->getDefaultByKey(ShowModeFooterActionBuilder::BTN_CREATE_AND_EDIT));
        } else {
            $actionButtons->addItem($actionButtons->getDefaultByKey(ShowModeFooterActionBuilder::BTN_UPDATE_AND_EDIT_AGAIN));
        }

        $actionButtons->addItem((new ShowModeFooterButtonItem())
            ->setClasses('btn btn-success')
            ->setName(ShowModeFooterActionBuilder::BTN_CUSTOM_REDIRECT)
            ->addIcon('fa-save')
            ->setRouteAction(MarkingAdminController::ROUTER_CHANGE_STATUS)
            ->setRouteQuery(http_build_query(['status' => Marking::STATUS_SEND_EXECUTION]))
            ->setTitle('Отправить на исполнение')
            ,
            );

        $this->setShowModeButtons($actionButtons->getButtonList());
    }
}