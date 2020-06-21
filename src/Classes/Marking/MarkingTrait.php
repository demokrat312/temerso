<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 11.06.2020
 * Time: 08:32
 */

namespace App\Classes\Marking;


use App\Classes\Task\TaskItem;
use App\Entity\Marking;
use App\Entity\User;

/**
 * Trait MarkingTrait
 * @package App\Classes\Marking
 *
 */
trait MarkingTrait
{
    /**
     * Тип задачи (поле для списка)
     * @see \App\Admin\MarkingAdmin::configureListFields
     * @return string
     */
    public function getTaskType()
    {
        return TaskItem::TYPE_TITLE[TaskItem::TYPE_MARKING];
    }

    /**
     * Исполнитель
     * @see \App\Admin\MarkingAdmin::configureListFields
     */
    public function getExecutor(): ?User
    {
        /** @var User $user */
        return $this->users->first() ?: null;
    }

    /**
     * @see templates/marking/show.html.twig
     * @return mixed
     */
    public function getStatusTitle()
    {
        return Marking::STATUS_TITLE[$this->status];
    }

    public function __toString()
    {
        return (string)$this->createdBy->getFio();
    }
}