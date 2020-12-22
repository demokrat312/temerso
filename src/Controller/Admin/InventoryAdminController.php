<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 26.05.2020
 * Time: 10:48
 */

namespace App\Controller\Admin;


use App\Classes\Inventory\RevisionControllerTrait;
use App\Classes\Task\TaskAdminController;
use App\Classes\Task\TaskItemInterface;
use App\Entity\Inventory;
use App\Entity\Marking;

class InventoryAdminController extends TaskAdminController
{
    use RevisionControllerTrait;

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
                    ->setComment(null)
                    ->setCommentProblemWithMark(null);
            }
        }
    }
}