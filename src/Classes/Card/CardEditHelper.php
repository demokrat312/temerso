<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-08-30
 * Time: 22:08
 */

namespace App\Classes\Card;


use App\Classes\ApiParentController;
use App\Classes\Marking\MarkingCardToTaskCardAdapter;
use App\Classes\Task\TaskItem;
use App\Classes\Task\TaskItemInterface;
use App\Classes\Utils;
use App\Entity\Card;
use App\Entity\CardTemporary;
use App\Entity\Inspection;
use App\Form\Data\Api\Card\CardEditData;
use App\Repository\CardTemporaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CardEditHelper
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var callable
     */
    private $toArray;

    public function __construct(EntityManagerInterface $em, callable $toArray)
    {
        $this->em = $em;
        $this->toArray = $toArray;
    }

    public function edit(CardEditData $cardEditData)
    {
        $card = $this->getCard($cardEditData);
        $task = $this->getTask($cardEditData);

        if ($task && $task instanceof Inspection) {
            $cardTemporary = $this->cardTempUpdate($cardEditData, $task, $card);
            $response = call_user_func($this->toArray, $cardTemporary, ApiParentController::GROUP_API_DEFAULT);
        } else {
            $this->cardUpdate($cardEditData, $card);
            $this->taskCardOtherFieldsUpdate($cardEditData, $card);
            $response = (new MarkingCardToTaskCardAdapter())->getCard($card, $cardEditData->getTaskTypeId(), $cardEditData->getTaskId());
        }

        $this->em->flush();

        return $response;
    }

    /**
     * @param CardEditData $cardEditData
     * @return Card|null
     */
    private function getCard(CardEditData $cardEditData)
    {
        $card = $this->em->getRepository(Card::class)->find($cardEditData->getId());
        if (!$card) {
            throw new NotFoundHttpException('Карточка не найдена');
        }
        return $card;
    }

    /**
     * @param CardEditData $cardEditData
     * @param Card|null $card
     */
    private function cardUpdate(CardEditData $cardEditData, ?Card $card)
    {
        if ($cardEditData->getRfidTagNo()) {
            $card->setRfidTagNo($cardEditData->getRfidTagNo());
        }
        if ($cardEditData->getAccounting()) {
            $card->setAccounting($cardEditData->getAccounting());
        }

        $this->em->persist($card);
    }

    /**
     * @param CardEditData $cardEditData
     * @param Card|null $card
     * @return |null
     */
    private function taskCardOtherFieldsUpdate(CardEditData $cardEditData, ?Card $card)
    {
        if ($cardEditData->getTaskId() && $cardEditData->getTaskTypeId()) {
            $taskCard = $card->getTaskCardOtherFieldsByTask($cardEditData->getTaskTypeId(), $cardEditData->getTaskId());
            $taskCard
                ->setCard($card)
                ->setTaskTypeId($cardEditData->getTaskTypeId() ?? $taskCard->getTaskTypeId())
                ->setTaskId($cardEditData->getTaskId() ?? $taskCard->getTaskId())
                ->setComment($cardEditData->getComment() ?? $taskCard->getComment())
                ->setCommentProblemWithMark($cardEditData->getCommentProblemWithMark() ?? $taskCard->getCommentProblemWithMark())
            ;

            $this->em->persist($taskCard);
        }
    }

    /**
     * Получаем задачу,
     * если есть id задачи
     *
     * @param CardEditData $cardEditData
     * @return object|TaskItemInterface
     */
    private function getTask(CardEditData $cardEditData): ?TaskItemInterface
    {
        $task = null;
        if ($cardEditData->getTaskId() && $cardEditData->getTaskTypeId()) {
            $taskClass = TaskItem::getTaskClass($cardEditData->getTaskTypeId());
            $task = $this->em->getRepository($taskClass)->find($cardEditData->getTaskId());
            if (!$task) throw new NotFoundHttpException('Задача не найденна');
        }

        return $task;
    }

    /**
     * @return \Doctrine\Persistence\ObjectRepository
     */
    private function rep(): \Doctrine\Persistence\ObjectRepository
    {
        return $this->em->getRepository(CardTemporary::class);
    }

    /**
     * Создаем или получаем из базы временную карточку
     * Пока только для инспекции
     *
     * @param CardEditData $cardEditData
     * @param TaskItemInterface|Inspection $task
     * @param Card|null $card
     * @return CardTemporary
     */
    private function cardTempUpdate(CardEditData $cardEditData, Inspection $task, ?Card $card): CardTemporary
    {
        // Создаем или получаем из базы временную карточку
        $cardTemporary = $task->getCardTemporary($card);
        $cardTemporary = $cardTemporary ?: new CardTemporary();

        if (!$cardEditData->getTaskTypeId() || !$cardEditData->getTaskTypeId()) {
            throw new BadRequestHttpException('Необходимо передать ключ задачи и тип задачи');
        }
        // Обезательные поля
        $cardTemporary
            ->setCard($card)
            ->setTaskTypeId($cardEditData->getTaskTypeId())
            ->setTaskId($cardEditData->getTaskId());

        // Копируем данные из текущей карточки во временную
        Utils::copyObject($cardTemporary, $card);

        //<editor-fold desc="Обновляем временную карточку">
        if ($cardEditData->getRfidTagNo()) {
            $cardTemporary->setRfidTagNo($cardEditData->getRfidTagNo());
        }
        if ($cardEditData->getAccounting()) {
            $cardTemporary->setAccounting($cardEditData->getAccounting());
        }
        if ($cardEditData->getComment()) {
            $cardTemporary->setComment($cardEditData->getComment());
        }
        if ($cardEditData->getCommentProblemWithMark()) {
            $cardTemporary->setCommentProblemWithMark($cardEditData->getCommentProblemWithMark());
            // если есть поле "оборудование естЬ, проблема с меткой", то учет true
            $cardTemporary->setAccounting(true);
        }
        //</editor-fold>

        // Добавляем временную карточку к задаче
        $task->addCardTemporary($cardTemporary);

        $this->em->persist($cardTemporary);
        return $cardTemporary;
    }
}