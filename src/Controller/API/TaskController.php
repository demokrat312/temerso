<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 18.06.2020
 * Time: 13:20
 */

namespace App\Controller\API;


use App\Classes\ApiParentController;
use App\Classes\Task\TaskHelper;
use App\Classes\Task\TaskItem;
use App\Classes\Task\TaskItemAdapter;
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
     *    description="Добавить карточки к задаче"
     *),
     *
     * \@SWG\Parameter( name="XDEBUG_SESSION", in="header", required=true, type="string", default="xdebug" )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Список заданий для текущего пользователя",
     *     @SWG\Schema(
     *           @SWG\Property(property="result",
     *           @Model(type=\App\Form\Type\Api\Task\TaskItemType::class))
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

        //<editor-fold desc="Маркировка">
        $markingList = $em->getRepository(Marking::class)->findAllTask($user->getId());
        $markingToTaskAdapter = new TaskItemAdapter();
        foreach ($markingList as $marking) {
            $taskList[] = $markingToTaskAdapter->getTask($marking);
        }
        //</editor-fold>

        $responseArray = TaskHelper::ins()
            ->tasksToArray($taskList, $request->get('withCards') == 'true');

        return $this->defaultResponse($responseArray);
    }

    /**
     * Получение списка карточек по id задачи и типу задания
     *
     * @Route("card-list", methods={"GET"}, name="api_task_card_list")
     *
     * @SWG\Parameter(
     *    name="id",
     *    in="query",
     *    type="number",
     *    description="Ключ задачи"
     * ),
     * @SWG\Parameter(
     *    name="taskTypeId",
     *    in="query",
     *    type="number",
     *    description="Тип задачи"
     * ),
     *
     * \@SWG\Parameter( name="XDEBUG_SESSION", in="header", required=true, type="string", default="xdebug" )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Список заданий для текущего пользователя",
     *     @SWG\Schema(
     *           @SWG\Property(property="result", type="array",
     *              @SWG\Items(ref=@Model(type=\App\Form\Type\Api\Card\CardItemType::class))
     *           )
     *     ),
     * )
     *
     * @Security(name="Bearer")
     *
     * @param Request $request
     */
    public function taskCardsAction(Request $request, EntityManagerInterface $em, TokenStorageInterface $storage)
    {
        //<editor-fold desc="Входные параметры и проверка">
        $taskId = (int)$request->get('id');
        $taskTypeId = (int)$request->get('taskTypeId');

        if (!$taskId || !$taskTypeId) {
            $this->errorResponse("Отсутсвуют необходимые параметры");
        }
        //</editor-fold>
        //<editor-fold desc="Получаем класс задачи">
        $taskClass = TaskItem::TYPE_CLASS[$taskTypeId] ?? false;
        if (!$taskClass) {
            return $this->errorResponse('Не известный тип задачи');
        }
        //</editor-fold>

        /** @var User $user */
        $user = $storage->getToken()->getUser();

        //<editor-fold desc="Получаем задачу">
        $entityItem = $em->getRepository($taskClass)->findTask($taskId, $user->getId());
        $markingToTaskAdapter = new TaskItemAdapter();
        $taskItem = $markingToTaskAdapter->getTask($entityItem);

        //</editor-fold>

        $responseArray = TaskHelper::ins()
            ->taskToArray($taskItem, true);

        return $this->defaultResponse($responseArray['cardList']);
    }
}