<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 26.05.2020
 * Time: 10:48
 */

namespace App\Controller\Admin;


use App\Entity\Marking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class MarkingAdminController extends DefaultAdminController
{
    const ROUTER_CHANGE_STATUS = 'change_status';

    /**
     * Смена статуса
     */
    public function changeStatusAction(Marking $marking, EntityManagerInterface $em, Request $request)
    {
        $marking
            ->setStatus((int)$request->get('status'));

        $em->persist($marking);
        $em->flush();

        $url = $this->admin->generateObjectUrl('show', $marking);
        return new RedirectResponse($url);
    }

    public function showAction($deprecatedId = null)
    {
        $request = $this->getRequest();
        $id = $request->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);
        $fields = $this->admin->getShow();
        return $this->renderWithExtraParams('making/show.html.twig', [
            'action' => 'show',
            'object' => $object,
            'elements' => $fields,
        ], null);
    }
}