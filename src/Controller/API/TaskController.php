<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 18.06.2020
 * Time: 13:20
 */

namespace App\Controller\API;


use App\Classes\ApiParentController;
use App\Classes\Marking\MarkingAccessHelper;
use App\Classes\Task\TaskHelper;
use App\Classes\Task\TaskItem;
use App\Classes\Task\TaskItemAdapter;
use App\Entity\Equipment;
use App\Entity\Inspection;
use App\Entity\Inventory;
use App\Entity\Marking;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/api/task/")
 *
 * @SWG\Tag(name="task")
 */
class TaskController extends ApiParentController
{
    /**
     * Список задача с проверкой по текущему пользователю и статусу задачи
     *
     * @Route("list", methods={"GET"}, name="api_task_list")
     *
     * @SWG\Parameter(
     *    name="withCards",
     *    in="query",
     *    type="boolean",
     *    description="Получить список задач вместе с карточками"
     *),
     *
     * \@SWG\Parameter( name="XDEBUG_SESSION", in="header", required=true, type="string", default="xdebug" )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Список заданий для текущего пользователя",
     *     @SWG\Schema(
     *           type="array",
     *           @Model(type=\App\Form\Type\Api\Task\TaskItemType::class)
     *     ),
     * )
     *
     * @Security(name="Bearer")
     */
    public function taskListAction(Request $request, EntityManagerInterface $em, TokenStorageInterface $storage)
    {
        /** @var User $user */
        $user = $storage->getToken()->getUser();
        $taskList = [];
        $withCards = $request->get('withCards') == 'true';
        $taskAdapter = new TaskItemAdapter();

        foreach ([
            $em->getRepository(Marking::class)->findAllTask($user->getId(), $withCards),
            $em->getRepository(Inventory::class)->findAllTask($user->getId(), $withCards),
            $em->getRepository(Inspection::class)->findAllTask($user->getId(), $withCards),
            $em->getRepository(Equipment::class)->findAllTask($user->getId(), $withCards),
                 ] as $entityList) {
            foreach ($entityList as $entity) {
                $taskList[] = $taskAdapter->getTask($entity, $withCards);
            }
        }

        $responseArray = TaskHelper::ins()
            ->tasksToArray($taskList);

        return $this->defaultResponse($responseArray);
    }

    /**
     * Меняем статус у задачи по id задачи и типу задачи
     *
     * @Route("change-status", methods={"POST"}, name="api_task_change_status")
     *
     * @SWG\Parameter(
     *    name="form",
     *    in="body",
     *    description="",
     *    @Model(type=\App\Form\Type\Api\Task\TaskChangeStatusType::class)
     * ),
     *
     * \@SWG\Parameter( name="XDEBUG_SESSION", in="header", required=true, type="string", default="xdebug" )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Если статус сменилься возвращаем фразу 'OK!'",
     *     @SWG\Schema( type="string"),
     * )
     *
     * @Security(name="Bearer")
     */
    public function changeStatusAction(Request $request, EntityManagerInterface $em, TokenStorageInterface $storage)
    {
        TaskHelper::ins()
            ->setEm($em)
            ->setUser($storage->getToken()->getUser());

        //<editor-fold desc="Параметры">
        $taskId = (int)$request->get('id');
        $taskTypeId = (int)$request->get('taskTypeId');
        $statusId = (int)$request->get('statusId');

        if (!($taskId && $taskTypeId && $statusId)) {
            return $this->errorParamResponse();
        }
        //</editor-fold>

        $taskClass = TaskItem::TYPE_CLASS[$taskTypeId] ?? false;
        //<editor-fold desc="Получаем задачу">
        $taskItem = TaskHelper::ins()->findTask($taskId, $taskClass);
        if (!$taskItem) {
            return $this->errorResponse(
                'У вас нету доступа к этой задаче или задача не существует',
                self::STATUS_CODE_403);
        }
        //</editor-fold>


        //<editor-fold desc="Проверяем права на смену статуса">
        $allowStatus = MarkingAccessHelper::getAllowStatusChange(
//            $storage->getToken()->getUser()->getRoles(),
            MarkingAccessHelper::USER_TYPE_EXECUTOR,
            $taskItem->getStatusId());

        if (!in_array($statusId, $allowStatus)) {
            return $this->errorResponse(
                'Нельзя менять на указанный статус, разрешенные статусы: '
                . ($allowStatus ? implode(',', $allowStatus) : 'нету'),
                self::STATUS_CODE_403);
        }
        //</editor-fold>

        //<editor-fold desc="Обновляем">
        if (TaskHelper::ins()->updateStatus($taskId, $taskClass, $statusId)) {
            return $this->defaultResponse(self::OK);
        } else {
            return $this->errorResponse('Не удалось изменить статус');
        }
        //</editor-fold>
    }
}