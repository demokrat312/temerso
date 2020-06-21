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

    /**
     * @var ?EntityManagerInterface
     */
    private $em;
    /**
     * @var ?User
     */
    private $user;

    static public function ins()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return mixed
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @param mixed $em
     * @return $this
     */
    public function setEm($em)
    {
        $this->em = $em;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
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

    /**
     * Получаем TaskItem или null если нету права или такой записи не существует
     *
     * @param int $taskId
     * @param string $taskClass
     * @return TaskItem|null
     */
    public function findTask(int $taskId, string $taskClass)
    {
        $entityItem = $this->findTaskEntity($taskId, $taskClass);

        $markingToTaskAdapter = new TaskItemAdapter();
        return $markingToTaskAdapter->getTask($entityItem);
    }

    private function findTaskEntity(int $taskId, string $taskClass)
    {
        $entityItem = $this->em->getRepository($taskClass)->findTask($taskId, $this->user->getId());
        if (!$entityItem) {
            return null;
        }

        return $entityItem;
    }

    public function updateStatus(int $taskId, string $taskClass, int $statusId): bool
    {
        $entityItem = $this->findTaskEntity($taskId, $taskClass);

        $entityItem->setStatus($statusId);

        $this->em->persist($entityItem);
        $this->em->flush();

        return true;
    }
}