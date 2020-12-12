<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 23.04.2020
 * Time: 18:32
 */

namespace App\Classes;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

abstract class MainAdmin extends AbstractAdmin
{
    const VIEW_LINK = [
        'identifier' => true,
        'route' => ['name' => 'show']
    ];

    const HIDE_LINK_MANY_TO_ONE = [
        'route' => ['name' => 'empty']
    ];

    protected $showModeButtons = [];

    protected function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->remove('acl');
    }

    protected function configureListFields(ListMapper $list)
    {
        if(!$list->has('batch')) {
            $list->add('batch', 'batch', ['code' => '_batch', 'template' => '@SonataAdmin/CRUD/list__batch.html.twig']);
        }
    }

    /**
     * @return string
     */
    public function getShowModeButtons(): array
    {
        return $this->showModeButtons;
    }

    /**
     * @param string $showModeButtons
     * @return $this
     */
    public function setShowModeButtons(array $showModeButtons)
    {
        $this->showModeButtons = $showModeButtons;
        return $this;
    }
}