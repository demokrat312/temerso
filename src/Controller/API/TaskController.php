<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 18.06.2020
 * Time: 13:20
 */

namespace App\Controller\API;


use App\Classes\Task\TaskItemAdapter;
use App\Entity\Marking;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/api/task/")
 *
 * @SWG\Tag(name="task")
 */
class TaskController extends AbstractController
{
    /**
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
        $markingList = $em->getRepository(Marking::class)->findTask($user->getId());
        $markingToTaskAdapter = new TaskItemAdapter();
        foreach ($markingList as $marking) {
            $taskList[] = $markingToTaskAdapter->getTask($marking);
        }
        //</editor-fold>


        $responseArray = [];
        foreach ($taskList as $task) {
            $taskArray = [
                'id' => $task->getId(),
                'statusId' => $task->getStatusId(),
                'statusTitle' => $task->getStatusTitle(),
                'taskTypeId' => $task->getTaskTypeId(),
                'taskTypeTitle' => $task->getTaskTypeTitle(),
                'createdByFio' => $task->getCreatedByFio(),
                'executorFio' => $task->getExecutorFio(),
            ];

            if ($request->get('withCards') == 'true') {
                $taskArray['cardList'] = $task->getCards();
            }

            $responseArray[] = $taskArray;
        }

        return $this->json([
            'result' => $responseArray
        ]);
    }
}