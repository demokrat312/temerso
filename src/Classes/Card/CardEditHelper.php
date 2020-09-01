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
use App\Classes\Utils;
use App\Entity\Card;
use App\Entity\CardTemporary;
use App\Entity\Inspection;
use App\Form\Data\Api\Card\CardEditData;
use App\Repository\CardTemporaryRepository;
use Doctrine\ORM\EntityManagerInterface;
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
            $cardTemporary = $task->getCardTemporary($card);
            $cardTemporary = $cardTemporary ?: new CardTemporary();

            $cardTemporary
                ->setCard($card)
                ->setTaskTypeId($cardEditData->getTaskTypeId())
            ;

            Utils::copyObject($cardTemporary, $card);

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
                $cardTemporary->setComment($cardEditData->getCommentProblemWithMark());
                // если есть поле "оборудование естЬ, проблема с меткой", то учет true
                $cardTemporary->setAccounting(true);
            }

            $task->addCardTemporary($cardTemporary);

            $this->em->persist($cardTemporary);

            $response = call_user_func($this->toArray, $cardTemporary, ApiParentController::GROUP_API_DEFAULT);
        } else {
            $this->cardUpdate($cardEditData, $card);
            $this->taskCardOtherFieldsUpdate($cardEditData, $card);
            $response = (new MarkingCardToTaskCardAdapter())->getCard($card, TaskItem::getTaskClass($cardEditData->getTaskTypeId()));
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
     * @return CardEditData
     */
    private function cardUpdate(CardEditData $cardEditData, ?Card $card): CardEditData
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
        if ($cardEditData->getTaskTypeId() && ($cardEditData->getComment() || $cardEditData->getCommentProblemWithMark())) {
            $taskCard = $card->getTaskCardOtherFieldsByTask(TaskItem::getTaskClass($cardEditData->getTaskTypeId()));
            $taskCard
                ->setCard($card)
                ->setTaskTypeId($cardEditData->getTaskTypeId())
                ->setComment($cardEditData->getComment())
                ->setCommentProblemWithMark($cardEditData->getCommentProblemWithMark());

            $this->em->persist($taskCard);
        }
    }

    /**
     * Получаем задачу,
     * если есть id задачи
     *
     * @param CardEditData $cardEditData
     */
    private function getTask(CardEditData $cardEditData)
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
}