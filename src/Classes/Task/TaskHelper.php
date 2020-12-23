<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 20.06.2020
 * Time: 14:54
 */

namespace App\Classes\Task;


use App\Classes\ApiParentController;
use App\Entity\Inventory;
use App\Entity\Marking;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Serializer;

class TaskHelper
{
    use InstanceTrait;

    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var User
     */
    private $user;

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
     * Получаем TaskItem или null если нет права или такой записи не существует
     *
     * @param int $taskId
     * @param string $taskClass
     * @return TaskItem|null
     */
    public function findTask(int $taskId, string $taskClass)
    {
        $entityItem = $this->findTaskEntity($taskId, $taskClass);
        if (!$entityItem) {
            return null;
        }

        $markingToTaskAdapter = new TaskItemAdapter();
        return $markingToTaskAdapter->getTask($entityItem);
    }

    /**
     * @return TaskItemInterface
     */
    private function findTaskEntity(int $taskId, string $taskClass)
    {
        /** @var \App\Classes\Task\TaskRepositoryParent $rep */
        $rep = $this->em->getRepository($taskClass);
        return $rep->findTask($taskId, $this->user->getId());
    }

    public function updateStatus(int $taskId, string $taskClass, int $statusId): bool
    {
        $entityItem = $this->findTaskEntity($taskId, $taskClass);
        if (!$entityItem) return false;

        if ($taskClass === TaskItem::TYPE_CLASS[TaskItem::TYPE_INSPECTION] && $statusId === Marking::STATUS_SAVE) {
            $statusId = Marking::STATUS_CONTINUE;
        }

        $entityItem->setStatus($statusId);

        $this->em->persist($entityItem);
        $this->em->flush();

        return true;
    }

    public function getTypeByEntityClass(string $entityClassName)
    {
        if (isset(TaskItem::TYPE_BY_CLASS[$entityClassName])) {
            return TaskItem::TYPE_BY_CLASS[$entityClassName];
        } else {
            throw new \Exception('add case to switch \App\Classes\Task\TaskItemAdapter::getTypeByEntity');
        }
    }
}