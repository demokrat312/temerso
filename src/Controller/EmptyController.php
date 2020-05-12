<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 12.05.2020
 * Time: 12:55
 */

namespace App\Controller;


use App\Classes\Dashboard\DashboardReference;
use Closure;
use Sonata\AdminBundle\Action\DashboardAction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class EmptyController extends AbstractController
{
    /**
     * @Route("/empty", name="admin_empty")
     */
    public function indexAction()
    {
        return $this->render('empty.html.twig');
    }

    /**
     * @Route("/reference-dasboard", name="admin_reference_dasboard")
     */
    public function referenceDashboardAction(Request $request, DashboardAction $dashboard)
    {
        $dashboardRef = new DashboardReference();
        $dashboardRef->changeBlocks($dashboard);

        return $dashboard($request);
    }
}