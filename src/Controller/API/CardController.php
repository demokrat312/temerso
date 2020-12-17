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
use App\Classes\Card\CardEditHelper;
use App\Classes\Card\CardIdentificationResponse;
use App\Classes\Marking\MarkingCardToTaskCardAdapter;
use App\Classes\Task\TaskHelper;
use App\Classes\Task\TaskItem;
use App\Classes\Task\TaskItemAdapter;
use App\Classes\Utils;
use App\Entity\Card;
use App\Entity\CardTemporary;
use App\Entity\Inspection;
use App\Entity\Marking;
use App\Entity\User;
use App\Form\Data\Api\Card\CardEditData;
use App\Form\Data\Api\Card\CardImageData;
use App\Form\Data\Api\Card\CardImageListData;
use App\Form\Data\Api\Card\CardListEditData;
use App\Form\Type\Api\Card\CardEditType;
use App\Form\Type\Api\Card\CardImageListType;
use App\Form\Type\Api\Card\CardImageType;
use App\Form\Type\Api\Card\CardListEditType;
use App\Form\Type\Card\CardIdentificationType;
use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use Sonata\MediaBundle\Model\MediaInterface;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * Карточки
 *
 * @Route("/api/card/")
 *
 * @SWG\Tag(name="card - карточка")
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

        $responseArray = $this->toArray($taskItem, self::GROUP_API_DEFAULT);

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
     *
     * @SWG\Response(
     *     response="200",
     *     description="Возвращаем сохраненную карточку",
     *     @Model(type=\App\Form\Type\Api\Card\CardItemType::class)
     * )
     *
     * @Security(name="Bearer")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function editAction(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CardEditType::class);
        $form->submit($request->request->all());

        if ($form->isValid()) {

            $toArray = function ($object, $group) {
                return $this->toArray($object, $group);
            };
            $cardEditHelper = new CardEditHelper($em, $toArray);

            $response = $cardEditHelper->edit($form->getData());


            return $this->defaultResponse($response);
        } else {
            return $this->errorParamResponse();
        }
    }

    /**
     * Редактирование списка карточек
     *
     * @Route("edit/list", methods={"POST"}, name="api_card_list_edit")
     *
     * @SWG\Parameter(
     *    name="form",
     *    in="body",
     *    description="Данные для сохранения",
     *    @Model(type=\App\Form\Data\Api\Card\CardListEditData::class)
     * ),
     *
     *
     * @SWG\Response(
     *     response="200",
     *     description="Если карточки сохранились возвращаем фразу 'OK!'",
     *     @SWG\Schema( type="string", example="OK!"),
     * )
     *
     *
     * @SWG\Response(
     *     response="404",
     *     description="Некоторые карточки не найденны",
     *     @SWG\Schema(
     *           type="object",
     *           @SWG\Property(property="message", type="string", example="Некоторые карточки не найденны"),
     *           @SWG\Property(property="cardsIdNotFound", type="array", @SWG\Items(type="number", example=1))),
     *     ),
     * )
     *
     * @Security(name="Bearer")
     */
    public function editListAction(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CardListEditType::class);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            /** @var CardListEditData $data */
            $data = $form->getData();
            $errors = [];

            foreach ($data->getList() as $cardData) {
                $toArray = function ($object, $group) {
                    return $this->toArray($object, $group);
                };
                $cardEditHelper = new CardEditHelper($em, $toArray);

                $cardEditHelper->edit($cardData);
            }

            if (count($errors) > 0) {
                return $this->errorResponse('Некоторые карточки не найденны', self::STATUS_CODE_404, ['cardsIdNotFound' => $errors]);
            }
            return $this->defaultResponse(self::OK);
        }

        return $this->formErrorResponse($form);
    }

    /**
     * Загрузка изображения
     * allowed_extensions: ['jpg', 'png', 'jpeg']
     *
     * @Route("file/{id}", methods={"POST"}, name="api_card_file")
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
     *      name="taskId",
     *      in="formData",
     *      required=false,
     *      type="number",
     *      description="Ключ задачи"
     * )
     * @SWG\Parameter(
     *      name="taskTypeId",
     *      in="formData",
     *      required=false,
     *      type="number",
     *      description="Тип родительской задачи"
     * )
     *
     * @SWG\Response(
     *     response="200",
     *     description="Если изображение сохранилось возвращаем фразу 'OK!'",
     *     @SWG\Schema( type="string"),
     * )
     *
     * @Security(name="Bearer")
     */
    public function CardFileAction(Request $request, EntityManagerInterface $em, Card $card)
    {
        $form = $this->createForm(CardImageType::class);
        $form->submit(array_merge($request->request->all(), $request->files->all()));

        if ($form->isValid()) {
            /** @var CardImageData $formData */
            $formData = $form->getData();

            // Если это изображение уже добавлялось, то не добавляем еще раз
            $hasMedia = false;
            $media = $this->getMedia($formData->getImage());

            //<editor-fold desc="Добавление изображения к временной карточки. Только для испекции для определенных статусов">
            /** @var Inspection $inspection */

            $hasCardTemporary = false;
            // Проверяем на испекцию
            if ($formData->getTaskTypeId() == TaskItem::TYPE_INSPECTION) {

                // Получаем инспекцию
                $inspection = $em->getRepository(Inspection::class)->find((int)$formData->getTaskId());
                if (!$inspection) throw new NotFoundHttpException('Задача не найдена');

                // Проверяем на нужный статус и добавляем изображение
                if (in_array($inspection->getStatus(), Marking::STATUS_CARD_TEMPORARY)) {
                    $hasCardTemporary = true;
                    $cardTemporary = $inspection->getCardTemporary($card);
                    $cardTemporary = $cardTemporary ?: new CardTemporary();

                    $hasMedia = $this->hasMedia($cardTemporary, $media);
                    $cardTemporary->addImage($media);
                }
            }

            //</editor-fold>

            //<editor-fold desc="Добавление изображения к карточке">
            if (!$hasCardTemporary) {
                $hasMedia = $this->hasMedia($card, $media);
                $card->addImage($media);
                $em->persist($card);
            }
            //</editor-fold>

            $em->persist($media);

            if($hasMedia) {
                $em->clear();
            } else {
                $em->flush();
            }

            return $this->defaultResponse(self::OK);
        } else {
            return $this->formErrorResponse($form);
        }
    }

    /**
     * Загрузка множественных изображений для множественный карточек
     *
     * @Route("list/files", methods={"POST"}, name="api_card_list_files")
     *
     * @SWG\Parameter(
     *    name="form",
     *    in="body",
     *    description="Данные для загрузки изображений",
     *    @Model(type=CardImageListData::class)
     * ),
     *
     *
     * @SWG\Response(
     *     response="200",
     *     description="Если изображение сохранилось возвращаем фразу 'OK!'",
     *     @SWG\Schema( type="string"),
     * )
     *
     * @Security(name="Bearer")
     */
    public function cardFileListAction(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CardImageListType::class);
        $reqFields = $request->request->all();
        $reqFiles = $request->files->all();
        $form->submit(Utils::array_merge_recursive_distinct($reqFields, $reqFiles));

        if ($form->isValid()) {
            /** @var CardImageListData $formData */
            $formData = $form->getData();

            /** @var Inspection $inspection */
            /** @var CardRepository $cardRep */

            //<editor-fold desc="Проверяем на временную карточку">
            $hasCardTemporary = false;
            // Проверяем на испекцию
            if ($formData->getTaskTypeId() == TaskItem::TYPE_INSPECTION) {

                // Получаем инспекцию
                $inspection = $em->getRepository(Inspection::class)->find((int)$formData->getTaskId());
                if (!$inspection) throw new NotFoundHttpException('Задача не найдена');

                // Проверяем на нужный статус и добавляем изображение
                if (in_array($inspection->getStatus(), Marking::STATUS_CARD_TEMPORARY)) {
                    $hasCardTemporary = true;
                }
            }
            //</editor-fold>

            $cardRep = $em->getRepository(Card::class);
            foreach ($formData->getCards() as $cardData) {
                // Получаем карточку
                $card = $cardRep->find($cardData->getCardId());
                if (!$card) throw new NotFoundHttpException('Карточка с id=' . $cardData->getCardId() . ' не найдена');

                // Добавляем изображение к временной карточке
                if ($hasCardTemporary) {
                    $cardTemporary = $inspection->getCardTemporary($card);
                    $cardTemporary = $cardTemporary ?: new CardTemporary();

                    foreach ($cardData->getImages() as $imageData) {
                        $media = $this->getMedia($imageData);
                        $cardTemporary->addImage($media);
                        $em->persist($media);
                    }
                    $em->persist($cardTemporary);
                    // К основной карточке
                } else {
                    foreach ($cardData->getImages() as $imageData) {
                        $media = $this->getMedia($imageData);
                        $card->addImage($media);
                        $em->persist($media);
                    }
                    $em->persist($card);
                }

            }
            $em->flush();

            return $this->defaultResponse(self::OK);
        } else {
            return $this->formErrorResponse($form);
        }
    }

    private function getMedia($binaryContent)
    {
        if (empty($binaryContent)) {
            throw new NotFoundHttpException('Изображение не найдено');
        }
        if($binaryContent instanceof UploadedFile) {
            $name = $binaryContent->getClientOriginalName();
            $uniqId = sha1($name . uniqid()) . '.' . $binaryContent->guessExtension();
        } else {
            $name = random_int(11111, 99999);
            $uniqId = sha1( uniqid() . random_int(11111, 99999));
        }

        $provider = 'sonata.media.provider.image';
        $context = 'card';


        $media = new Media();
        $media->setName($name);
        $media->setBinaryContent($binaryContent);
        $media->setContext($context);
        $media->setProviderName($provider);
        $media->setProviderStatus(MediaInterface::STATUS_OK);
        $media->setProviderReference($uniqId);
        $media->setEnabled(true);

        return $media;
    }

    /**
     * Идентификация/поиск карточки(кароточек)
     *
     * Если найдена 1 карточка, то в поле card будет карточка, в поле multiple=false
     * Если найдено несколько карточек, то в поле cardList массив карточек в поле multiple=true
     *
     * @Route("identification", methods={"POST"}, name="api_card_list_identification")
     *
     * @SWG\Parameter(
     *    name="form",
     *    in="body",
     *    description="Данные для идентификации",
     *    @Model(type=\App\Form\Type\Card\CardIdentificationType::class)
     * ),
     *
     * @SWG\Response(
     *     response="200",
     *     description="Возвращаем найденую карточку или карточки",
     *     @SWG\Schema(
     *           type="array",
     *           @SWG\Items(ref=@Model(type=\App\Classes\Card\CardIdentificationResponse::class, groups={CardIdentificationResponse::GROUP_API_DEFAULT}))
     *     ),
     * )
     *
     * @SWG\Response(
     *     response="404",
     *     description="Не найдено ни одной карточки",
     *     @SWG\Schema(
     *            ref=@Model(type=\App\Classes\Error\ErrorResponse::class, groups={\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     *      ),
     * )
     *
     * @Security(name="Bearer")
     *
     * @param Request $request
     */
    public function identificationAction(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CardIdentificationType::class);
        $form->submit($request->request->all());
        if ($form->isValid()) {
            /** @var CardRepository $rep */
            $rep = $em->getRepository(Card::class);
            $cards = $rep->findByCardIdentificationData($form->getData());

            if (count($cards) === 1) {
                $cardsResponse = [];
                $cardResponse = $cards[0];
                $multiple = false;
            } else if (count($cards) > 1) {
                $cardsResponse = $cards;
                $cardResponse = null;
                $multiple = true;
            } else {
                return $this->errorResponse('Не найдено ни одной карточки', self::STATUS_CODE_404);
            }

            $response = new CardIdentificationResponse();
            $response
                ->setCard($cardResponse)
                ->setCardList($cardsResponse)
                ->setMultiple($multiple);

            return $this->defaultResponse($this->toArray($response, CardIdentificationResponse::GROUP_API_DEFAULT));
        } else {
            return $this->formErrorResponse($form);
        }
    }

    /**
     * @param CardTemporary|Card $card
     * @param Media $media
     * @return bool
     */
    private function hasMedia($card, Media $media): bool
    {
        $hasMedia = false;
        foreach ($card->getImages() as $image) {
            if ($image->getName() === $media->getName()) {
                $hasMedia = true;
                break;
            }
        }
        return $hasMedia;
    }
}