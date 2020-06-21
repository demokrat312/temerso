<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 26.05.2020
 * Time: 10:48
 */

namespace App\Classes\Task;


use App\Classes\Arrival\ExcelHelper;
use App\Classes\Arrival\MarkingCells;
use App\Controller\Admin\DefaultAdminController;
use App\Service\Access\MarkingAccessService;
use App\Entity\Marking;
use App\Service\AdminRouteService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class TaskAdminController extends DefaultAdminController
{
    const ROUTER_CHANGE_STATUS = 'change_status';
    const ROUTER_REMOVE_EXECUTOR = 'remove_executor';
    const ROUTER_EXCEL = 'excel';

    /**
     * @var MarkingAccessService
     */
    private $accessService;
    /**
     * @var AdminRouteService
     */
    private $adminRoute;

    public function __construct(MarkingAccessService $accessService, AdminRouteService $adminRoute)
    {
        $this->accessService = $accessService;
        $this->adminRoute = $adminRoute;
    }

    abstract function getEntityClass(): string ;


    /**
     * Смена статуса
     * @see MarkingAdminController::ROUTER_CHANGE_STATUS
     */
    public function changeStatusAction(int $id, EntityManagerInterface $em, Request $request)
    {
        $task = $em->getRepository($this->getEntityClass())->find($id);
        if(!$task) {
            throw new NotFoundHttpException('Задача не найдена');
        }
        $task
            ->setStatus((int)$request->get('status'));

        if ($comment = $request->get('comment')) {
            $task->setComment($comment);
        }

        $em->persist($task);
        $em->flush();

        $url = $this->admin->generateObjectUrl('show', $task);
        return new RedirectResponse($url);
    }

    /**
     * @param Marking $task
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     * @see MarkingAdminController::ROUTER_REMOVE_EXECUTOR
     *
     */
    public function removeExecutorAction(int $id, EntityManagerInterface $em)
    {
        $task = $em->getRepository($this->getEntityClass())->find($id);
        if(!$task) {
            throw new NotFoundHttpException('Задача не найдена');
        }
        $task
            ->setStatus(Marking::STATUS_CREATED);

        foreach ($task->getUsers() as $user) {
            $task->removeUser($user);
        }

        $em->persist($task);
        $em->flush();

        $url = $this->admin->generateObjectUrl('edit', $task);
        return new RedirectResponse($url);
    }

    public function showAction($deprecatedId = null)
    {
        $request = $this->getRequest();
        $id = $request->get($this->admin->getIdParameter());
        $object = $this->admin->getObject($id);
        $fields = $this->admin->getShow();
        return $this->renderWithExtraParams('marking/show.html.twig', [
            'action' => 'show',
            'object' => $object,
            'elements' => $fields,
        ], null);
    }

    /**
     * @param Request $request
     * @param object|Marking $object
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    protected function preEdit(Request $request, $object)
    {
        if ($this->accessService->checkEdit($object->getStatus())) {
            return parent::preEdit($request, $object); // TODO: Change the autogenerated stub
        }

//        $message = sprintf('При статусе "%s" нельзя редактировать', Marking::STATUS_TITLE[$object->getStatus()] ?? $object->getStatus());
//        $this->getRequest()->getSession()->getFlashBag()->add("error", $message);

        $route = $this->adminRoute->getActionRoute($this->getEntityClass(), 'show', ['id' => $object->getId()]);
        return new RedirectResponse($route);

    }

    /**
     * @link https://packagist.org/packages/onurb/excel-bundle
     */
    public function excelAction(int $id)
    {
        /** @var Marking $marking */
        $marking = $this->admin->getSubject();

        if (!$marking) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id: %s', $id));
        }

        $excelHelper = new ExcelHelper($this->get('phpspreadsheet'));
        $excelHelper->setSource('templates/excelFile/marking_excel.xlsx');


        // Задаем общию информацию
        $markingСells = new MarkingCells();
        $markingСells
            ->setActiveSheet($excelHelper->getActiveSheet())
            ->setGeneral($marking)
        ;

        if ($marking->getCards()->count() > 0) {
            $startRow = 6;
            $markingСells
                ->duplicateRow($startRow, $marking->getCards()->count())
                ->setCars($startRow, $marking->getCards());
        }

        $excelHelper->print();
    }


}