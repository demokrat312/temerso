<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 02.05.2020
 * Time: 18:21
 */

namespace App\Admin;

use App\Classes\MainAdmin;
use App\Classes\ShowAdmin\ShowModeFooterActionBuilder;
use App\Entity\Card;
use App\Form\Type\AdminListType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Партия
 *
 * Class ArrivalAdmin
 * @package App\Admin
 */
class KitAdmin extends MainAdmin
{

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection
            ->remove('create')
            ->remove('edit')
            ->remove('show')
            ->remove('export')
        ;
    }
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('createAt', null, self::VIEW_LINK)
            ->add('createdBy', null, self::HIDE_LINK_MANY_TO_ONE)
            ->add('comment');
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('general', ['label' => 'Главная', 'class' => 'col-md-12'])
                ->add('comment')
                ->add('cards')
            ->end();
    }

    protected function configureFormFields(FormMapper $editForm)
    {
        $editForm
            ->with('general', ['label' => 'Главная', 'class' => 'col-md-12'])
                ->add('comment')
                ->add('cards', AdminListType::class, [
                    'class' => Card::class,
                    'field_show_name' => 'generalName',
                    'multiple' => true,
                    'label' => 'Карточки',
            ])
            ->end();


        $actionButtons = new ShowModeFooterActionBuilder();

        if ($this->isCurrentRoute('create')) {
            $actionButtons->addItem($actionButtons->getDefaultByKey(ShowModeFooterActionBuilder::BTN_CREATE_AND_EDIT));
        } else {
            $actionButtons->addItem($actionButtons->getDefaultByKey(ShowModeFooterActionBuilder::BTN_UPDATE_AND_EDIT_AGAIN));
        }

        $this->setShowModeButtons($actionButtons->getButtonList());
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
    }
}