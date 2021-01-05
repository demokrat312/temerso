<?php


namespace App\Classes\Card;


use App\Classes\Task\InstanceTrait;
use App\Classes\Task\TaskWithCardsTemporaryInterface;

class CardTemporaryHelper
{
    /**
     * Если ли у переданной задачи временные карточки
     */
    public static function isAllowEditCardTemporary($task)
    {
        return $task &&
            is_object($task) &&
            $task instanceof TaskWithCardsTemporaryInterface &&
            $task->allowEditCardTemporary();
    }
}