<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 18.05.2020
 * Time: 23:43
 */

namespace App\Controller\Admin;


use App\Classes\Dashboard\DashboardReference;
use Sonata\AdminBundle\Action\DashboardAction;
use Sonata\AdminBundle\Controller\CRUDController;

class ReferenceDashboardController extends CRUDController
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
        $dashboardRef = new DashboardReference();
        $dashboardRef->changeBlocks($this->dashboard);

        return $this->dashboard->__invoke($this->getRequest());
    }

}