<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 21.06.2020
 * Time: 14:29
 */

namespace App\Controller\API;


use App\Application\Sonata\MediaBundle\Entity\Media;
use App\Classes\ApiParentController;
use App\Classes\Marking\MarkingCardToTaskCardAdapter;
use App\Classes\Task\TaskHelper;
use App\Classes\Task\TaskItem;
use App\Classes\Task\TaskItemAdapter;
use App\Entity\Card;
use App\Entity\User;
use App\Form\Type\Api\Card\CardEditType;
use App\Form\Type\Api\Card\CardImageType;
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
     *           type="array",
     *           @SWG\Items(ref=@Model(type=\App\Form\Type\Api\Card\CardItemType::class))
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
        if (!$entityItem) {
            return $this->errorResponse('Задача не найденна');
        }
        $markingToTaskAdapter = new TaskItemAdapter();
        $taskItem = $markingToTaskAdapter->getTask($entityItem, true);

        //</editor-fold>

        $responseArray = TaskHelper::ins()
            ->taskToArray($taskItem);

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
     * \@SWG\Parameter( name="XDEBUG_SESSION", in="header", required=true, type="string", default="xdebug" )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Возвращаем сохраненную карточку",
     *     @Model(type=\App\Form\Type\Api\Card\CardItemType::class)
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

            $taskEntityClass = null;
            if ($data['taskTypeId'] && ($data['comment'] || $data['commentProblemWithMark'])) {
                $taskEntityClass = TaskItem::TYPE_CLASS[$data['taskTypeId']];
                $taskCard = $card->getTaskCardOtherFieldsByTask(new $taskEntityClass());
                $taskCard
                    ->setCard($card)
                    ->setTaskTypeId($data['taskTypeId'])
                    ->setComment($data['comment'])
                    ->setCommentProblemWithMark($data['commentProblemWithMark']);

                $em->persist($taskCard);
            }


            $em->persist($card);
            $em->flush();


            return $this->defaultResponse((new MarkingCardToTaskCardAdapter())->getCard($card, $taskEntityClass));
        } else {
            return $this->errorParamResponse();
        }
    }

    /**
     * Загрузка изображения
     * allowed_extensions: ['jpg', 'png', 'jpeg']
     *
     * @Route("file", methods={"POST"}, name="api_card_file")
     *
     * @SWG\Parameter(
     *      name="image",
     *      in="formData",
     *      required=true,
     *      type="file",
     *      description="Изображение"
     * )
     *
     * @SWG\Parameter(
     *      name="id",
     *      in="formData",
     *      required=true,
     *      type="number",
     *      description="Ключ, карточки"
     * )
     *
     * \@SWG\Parameter( name="XDEBUG_SESSION", in="header", required=true, type="string", default="xdebug" )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Если изображение сохранилось возвращаем фразу 'OK!'",
     *     @SWG\Schema( type="string"),
     * )
     *
     * @Security(name="Bearer")
     */
    public function CardFileAction(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CardImageType::class);
        $form->submit(array_merge($request->request->all(), $request->files->all()));

        if ($form->isValid()) {
            $formData = $form->getData();
            $card = $em->getRepository(Card::class)->find($formData['id']);
            if (!$card) {
                return $this->errorResponse('Карточка не найдена');
            }

            $media = $this->getMedia($formData['image']);

            $card->addImage($media);

            $em->persist($media);
            $em->persist($card);

            $em->flush();

            return $this->defaultResponse(self::OK);
        } else {
            return $this->formErrorResponse($form);
        }
    }

    private function getMedia($binaryContent) {

        $provider = 'sonata.media.provider.image';
        $context = 'card_inventory';

        $media = new Media();
        $media->setBinaryContent($binaryContent);
        $media->setContext($context);
        $media->setProviderName($provider);

        $media->setEnabled(true);

        return $media;
    }
}