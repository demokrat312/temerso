<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 21.06.2020
 * Time: 14:29
 */

namespace App\Controller\API;


use App\Classes\ApiParentController;
use App\Classes\Marking\MarkingCardToTaskCardAdapter;
use App\Classes\Task\TaskHelper;
use App\Classes\Task\TaskItem;
use App\Classes\Task\TaskItemAdapter;
use App\Entity\Card;
use App\Entity\User;
use App\Form\Type\Api\Card\CardEditType;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * Карточки
 *
 * @Route("/api/card/")
 *
 * @SWG\Tag(name="card")
 */
class CardController extends ApiParentController
{
    /**
     * Получение списка карточек по id задачи и типу задания
     *
     * @Route("list-by-task", methods={"GET"}, name="api_card_list_by_task")
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
            return $this->errorParamResponse();
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
        if(!$entityItem) {
            return $this->errorResponse('Задача не найденна');
        }
        $markingToTaskAdapter = new TaskItemAdapter();
        $taskItem = $markingToTaskAdapter->getTask($entityItem);

        //</editor-fold>

        $responseArray = TaskHelper::ins()
            ->taskToArray($taskItem, true);

        return $this->defaultResponse($responseArray['cardList']);
    }

    /**
     * Редактирование карточки
     *
     * @Route("edit", methods={"POST"}, name="api_card_edit")
     *
     * @SWG\Parameter(
     *    name="form",
     *    in="body",
     *    description="Данные для сохранения",
     *    @Model(type=\App\Form\Type\Api\Card\CardEditType::class)
     * ),
     *
     * @SWG\Parameter( name="XDEBUG_SESSION", in="header", required=true, type="string", default="xdebug" )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Возвращаем сохраненную карточку",
     *     @SWG\Schema(
     *           @SWG\Property(property="result",
     *           @Model(type=\App\Form\Type\Api\Card\CardItemType::class))
     *     ),
     * )
     *
     * @Security(name="Bearer")
     */
    public function editAction(Request $request, EntityManagerInterface $em, TokenStorageInterface $storage)
    {
        $form = $this->createForm(CardEditType::class);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $data = $form->getData();
            $card = $em->getRepository(Card::class)->find($data['id']);
            if (!$card) {
                return $this->errorResponse('Карточка не найдена');
            }

            $card->setRfidTagNo($data['rfidTagNo']);

            $em->persist($card);
            $em->flush();


            return $this->defaultResponse((new MarkingCardToTaskCardAdapter())->getCard($card));
        } else {
            return $this->errorParamResponse();
        }
    }
}