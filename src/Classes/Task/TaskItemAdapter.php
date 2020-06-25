<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 19.06.2020
 * Time: 10:34
 */

namespace App\Classes\Task;


class TaskItemAdapter
{
    public function getTask(TaskItemInterface $taskEntity, bool $withCards = false): TaskItem
    {
        $task = new TaskItem();
        // Поля из сущности
        $task
            ->setId($taskEntity->getId())
            ->setCreatedBy($taskEntity->getCreatedBy())
            ->setStatusId($taskEntity->getStatus())
            ->setExecutor($taskEntity->getExecutor())
            ->setComment($taskEntity->getComment())
            ->setTaskTypeId($this->getTypeByEntityClass(get_class($taskEntity)))
        ;

        if($withCards) {
            $task->setCardList($taskEntity->getCards());
        }

        return $task;
    }

    private function getTypeByEntityClass(string $entityClassName)
    {
        return TaskHelper::ins()->getTypeByEntityClass($entityClassName);
    }
}