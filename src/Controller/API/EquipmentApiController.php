<?php

namespace App\Controller\API;


use App\Classes\ApiParentController;
use App\Classes\Equipment\EquipmentErrorResponse;
use App\Entity\Card;
use App\Entity\Equipment;
use App\Entity\EquipmentKit;
use App\Entity\User;
use App\Form\Data\Api\Card\CardAddToEquipmentData;
use App\Form\Data\Api\Card\CardListAddToEquipmentData;
use App\Form\Type\Api\Card\CardAddToEquipmentType;
use App\Form\Type\Api\Card\CardListAddToEquipmentType;
use App\Repository\CardRepository;
use App\Repository\EquipmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Swagger\Annotations as SWG;

/**
 * Комплектация в аренду
 *
 * @Route("/api/equipment/")
 * @SWG\Tag(name="equipment - Комплектация в аренду")
 */
class EquipmentApiController extends ApiParentController
{
    /**
     * Комплектация в аренду. Получение записи по id
     *
     * @Route("item", methods={"GET"}, name="api_equipment_item")
     *
     * @SWG\Parameter(
     *    name="id",
     *    in="query",
     *    type="number",
     *    description="Ключ записи. Нужно брать из задачи поле id с taskTypeId=4."
     * ),
     *
     *
     * @SWG\Response(
     *     response="200",
     *     description="Возвращаем запись",
     *     @Model(type=Equipment::class, groups={ApiParentController::GROUP_API_DEFAULT})
     * )
     *
     * @Security(name="Bearer")
     */
    public function item(Request $request, EntityManagerInterface $em, TokenStorageInterface $storage)
    {
        $id = $request->get('id');
        /** @var User $user */
        $user = $storage->getToken()->getUser();
        /** @var EquipmentRepository $rep */
        $rep = $em->getRepository(Equipment::class);

        $equipment = $rep->findTask($id, $user->getId());
        if (!$equipment) {
            return $this->errorResponse('Запись не найденна или у вас нету доступа');
        }

        return $this->defaultResponse($this->toArray($equipment, ApiParentController::GROUP_API_DEFAULT));
    }


    /**
     * Добавление карточки к комплекту.
     *
     * Добавление по id комлпекта.
     * Поиск карточки по следующим полям:серийный номер трубы, серийный номер муфты, серийный номер ниппеля.
     * По RFID метке ИЛИ серийным номерам
     *
     * @Route("add-card", methods={"POST"}, name="api_equipment_add_card")
     *
     * @SWG\Parameter(
     *    name="form",
     *    in="body",
     *    description="Данные для поиска карточки",
     *    @Model(type=\App\Form\Type\Api\Card\CardAddToEquipmentType::class)
     * ),
     *
     * @SWG\Response(
     *     response="200",
     *     description="Возвращаем добавленную карточку",
     *     @SWG\Schema(
     *            ref=@Model(type=\App\Entity\Card::class, groups={\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     *      ),
     * )
     *
     * @SWG\Response(
     *     response="404",
     *     description="Карточка не найдена",
     *     @SWG\Schema(
     *            ref=@Model(type=\App\Classes\Error\ErrorResponse::class)
     *      ),
     * )
     *
     * @SWG\Response(
     *     response="422",
     *     description="Ошибка валидации входящих данных",
     *     @SWG\Schema(
     *            ref=@Model(type=\App\Classes\Error\ErrorResponse::class)
     *      ),
     * )
     *
     * @Security(name="Bearer")
     */
    public function addCard(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(CardAddToEquipmentType::class);
        $form->submit($request->request->all());
        if ($form->isValid()) {
            /** @var CardAddToEquipmentData $data */
            $data = $form->getData();
            /** @var CardRepository $rep */
            $rep = $em->getRepository(Card::class);
            $card = $rep->findByCardAddToEquipmentType($data);

            /** @var EquipmentKit $equipmentKit */
            $equipmentKit = $em->getRepository(EquipmentKit::class)->find($data->getId());
            if (!$equipmentKit) {
                return $this->errorResponse('Комплект с id=' . $data->getId() . ' не найден');
            }

            if ($equipmentKit->getCards()->contains($card)) {
                return $this->errorResponse('Карточка уже есть в комплекте');
            }
            $equipmentKit->addCard($card);
            $em->persist($equipmentKit);
            $em->flush();

            return $this->defaultResponse($this->toArray($card, ApiParentController::GROUP_API_DEFAULT));
        } else {
            return $this->formErrorResponse($form);
        }
    }


    /**
     * Добавление списка карточек к комплекту.
     *
     * Добавление по id комлпекта.
     * Поиск карточки по следующим полям:серийный номер трубы, серийный номер муфты, серийный номер ниппеля.
     * По RFID метке ИЛИ серийным номерам
     *
     * @Route("add-card/list", methods={"POST"}, name="api_equipment_add_card_list")
     *
     * @SWG\Parameter(
     *    name="form",
     *    in="body",
     *    description="Данные для поиска карточки",
     *    @Model(type=CardListAddToEquipmentType::class)
     * ),
     *
     * @SWG\Response(
     *     response="200",
     *     description="Возвращаем добавленную карточку",
     *     @SWG\Schema(
     *            ref=@Model(type=\App\Entity\Card::class, groups={\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     *      ),
     * )
     *
     * @SWG\Response(
     *     response="400",
     *     description="Не удалось добавить карточки к комлекту",
     *     @SWG\Schema(
     *            ref=@Model(type=EquipmentErrorResponse::class)
     *      ),
     * )
     *
     * @SWG\Response(
     *     response="422",
     *     description="Ошибка валидации входящих данных",
     *     @SWG\Schema(
     *            ref=@Model(type=\App\Classes\Error\ErrorResponse::class)
     *      ),
     * )
     *
     * @Security(name="Bearer")
     */
    public function addCardListAction(Request $request, EntityManagerInterface $em)
    {

        // Создаем форму и записываем туда данные
        $form = $this->createForm(CardListAddToEquipmentType::class);
        $form->submit($request->request->all());

        // Проверяем форму
        if ($form->isValid()) {
            /** @var CardListAddToEquipmentData $cardListData */
            /** @var CardRepository $rep */
            /** @var EquipmentKit $equipmentKit */

            // Получаем данные из формы
            $cardListData = $form->getData();
            $rep = $em->getRepository(Card::class);

            // Получаем комплект
            $equipmentKit = $em->getRepository(EquipmentKit::class)->find($cardListData->getId());

            $error = [];
            $errorResponse = new EquipmentErrorResponse();

            // Проверяем каждую карточку и добавляем к комплекту
            if ($equipmentKit) {
                foreach ($cardListData->getList() as $cardList) {
                    try {
                        $card = $rep->findByCardAddToEquipmentType($cardList);

                        if ($equipmentKit->getCards()->contains($card)) {
                            throw new \Exception('Карточка уже есть в комплекте');
                        }

                        $equipmentKit->addCard($card);
                    } catch (\Exception $exception) {
                        $filterFieldSearch = function (CardAddToEquipmentData $cardList) {
                            foreach (get_class_methods($cardList) as $method) {
                                if(strpos($method, 'get') === 0 && !empty($cardList->{$method}())) {
                                    $fieldName = lcfirst(substr($method,3));
                                    return $fieldName . '=' . $cardList->{$method}() . ' : ';
                                }
                            }
                        };
                        $filterFieldSearchText = $filterFieldSearch($cardList);

                        $error[] = $filterFieldSearchText . $exception->getMessage();
                    }
                }
                if (count($error)) {
                    $errorResponse
                        ->setMessage('Возникла ошибка при добавлении карточки к комплекту')
                        ->setCardListError($error)
                    ;
                }
            } else {
                $errorResponse->setMessage('Комплект с id=' . $cardListData->getId() . ' не найден');
            }

            // Если хотябы одна карточка не добавилась
            if ($errorResponse->getMessage()) {
                return $this->errorResponse(
                    $errorResponse->getMessage(),
                    null,
                    ['cardListError' => $errorResponse->getCardListError()]
                );
            }

            $em->persist($equipmentKit);
            $em->flush();

            return $this->defaultResponse($this->toArray($card, ApiParentController::GROUP_API_DEFAULT));
        } else {
            return $this->formErrorResponse($form);
        }
    }
}