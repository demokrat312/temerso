<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 26.05.2020
 * Time: 10:48
 */

namespace App\Controller\Admin;


use App\Classes\Task\TaskAdminController;
use App\Classes\Task\TaskItemInterface;
use App\Entity\Inventory;
use App\Entity\Marking;

class InventoryAdminController extends TaskAdminController
{
    function getEntityClass(): string
    {
        return Inventory::class;
    }

    /**
     * @param TaskItemInterface|Inventory $taskItem
     * @param $newStatusId
     */
    protected function preChangeStatus(TaskItemInterface $taskItem, $newStatusId)
    {
        // Если "Отправленно на доработку", то сбрасываем комментарий
        if ($this->isRevision($taskItem->getStatus(), $newStatusId)) {
            $taskItem->setIsRevision(true);
            foreach ($taskItem->getCardsTemporary() as $cardTemporary) {
                $cardTemporary
                    ->setAccounting(false)
                    ->setAccounting(false)
                    ->setComment(null)
                    ->setCommentProblemWithMark(null);
            }
        }
    }

    /**
     * Проверяем если задача "Отправленно на доработку"
     *
     * Статус Отправленно на доработку не используется, понять что произошло это действие,
     * можно если текущий статус задачи "Отправить задание на проверку"
     * и меняем задачу на статус "Отправлено на исполнение"
     *
     * @param int $currentStatusId
     * @param int $newStatusId
     * @return bool
     */
    private function isRevision(int $currentStatusId, int $newStatusId)
    {
        return $currentStatusId === Marking::STATUS_SAVE && $newStatusId === Marking:: STATUS_SEND_EXECUTION;
    }
}