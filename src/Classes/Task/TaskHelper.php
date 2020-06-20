<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 20.06.2020
 * Time: 14:54
 */

namespace App\Classes\Task;


class TaskHelper
{
    private static $instance;

    static public function ins()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param array|TaskItem[] $taskList
     */
    public function tasksToArray(array $taskList, bool $witCards = false)
    {
        $responseArray = [];
        foreach ($taskList as $task) {
            $responseArray[] = $this->taskToArray($task, $witCards);
        }

        return $responseArray;
    }

    /**
     * @param array|TaskItem[] $taskList
     */
    public function taskToArray(TaskItem $task, bool $witCards = false)
    {
        $taskArray = [
            'id' => $task->getId(),
            'statusId' => $task->getStatusId(),
            'statusTitle' => $task->getStatusTitle(),
            'taskTypeId' => $task->getTaskTypeId(),
            'taskTypeTitle' => $task->getTaskTypeTitle(),
            'createdByFio' => $task->getCreatedByFio(),
            'executorFio' => $task->getExecutorFio(),
        ];

        if ($witCards) {
            $taskArray['cardList'] = $task->getCards();
        }

        return $taskArray;
    }
}