<?php


namespace App\Classes\Inventory;


use App\Entity\Marking;

trait RevisionControllerTrait
{
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