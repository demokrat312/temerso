<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 26.05.2020
 * Time: 10:48
 */

namespace App\Controller\Admin;


use App\Classes\Card\CardEditHelper;
use App\Classes\Card\CardStatusHelper;
use App\Classes\Inventory\RevisionControllerTrait;
use App\Classes\Task\TaskAdminController;
use App\Classes\Task\TaskItem;
use App\Classes\Task\TaskItemInterface;
use App\Entity\Card;
use App\Entity\Equipment;
use App\Entity\Inventory;
use App\Entity\Marking;

class EquipmentAdminController extends TaskAdminController
{
    use RevisionControllerTrait;

    function getEntityClass(): string
    {
        return Equipment::class;
    }

    /**
     * При завершении задачи, меняем статус карточек на в аренде
     *
     * @param TaskItemInterface|Equipment $taskItem
     * @param $newStatusId
     */
    protected function preChangeStatus(TaskItemInterface $taskItem, $newStatusId)
    {
        $isComplete = $newStatusId === Marking::STATUS_COMPLETE; // Задача завершена
        if ($isComplete) {
            $em = $this->getDoctrine()->getManager();
            $taskItem->getCards()->map(function (Card $card) use ($em) {
                $card->setStatus(CardStatusHelper::STATUS_RENT);
                $em->persist($card);
            });
        }

        // Если "Отправленно на доработку", то сбрасываем комментарий
        if ($this->isRevision($taskItem->getStatus(), $newStatusId)) {
            $taskItem->setIsRevision(true);
            $cardEditHelper = new CardEditHelper($this->getDoctrine()->getManager());
            foreach ($taskItem->getKits() as $kit) {
                foreach ($kit->getCards() as $card) {
                    // Убнуляем дополнительные поля карточки
                    $cardEditHelper->taskCardOtherFieldsReset($card, TaskItem::TYPE_EQUIPMENT, $taskItem->getId());
                }
            }
        }
    }
}