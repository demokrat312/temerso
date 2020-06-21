<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 19.06.2020
 * Time: 10:34
 */

namespace App\Classes\Task;


use App\Entity\Inventory;
use App\Entity\Marking;

class TaskItemAdapter
{
    public function getTask(TaskItemInterface $marking): TaskItem
    {
        $task = new TaskItem();
        // Поля из сущности
        $task
            ->setId($marking->getId())
            ->setCreatedBy($marking->getCreatedBy())
            ->setStatusId($marking->getStatus())
            ->setExecutor($marking->getExecutor())
            ->setCards($marking->getCards())
            ->setTaskTypeId($this->getTypeByEntity(get_class($marking)));

        return $task;
    }

    private function getTypeByEntity(string $entityClassName)
    {
        switch ($entityClassName) {
            case Marking::class:
                return TaskItem::TYPE_MARKING;
            case Inventory::class:
                return TaskItem::TYPE_INVENTORY;
            default:
                throw new \Exception('add case to switch \App\Classes\Task\TaskItemAdapter::getTypeByEntity');
        }
    }
}