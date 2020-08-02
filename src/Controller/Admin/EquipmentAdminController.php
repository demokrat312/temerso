<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 26.05.2020
 * Time: 10:48
 */

namespace App\Controller\Admin;


use App\Classes\Card\CardStatusHelper;
use App\Classes\Task\TaskAdminController;
use App\Classes\Task\TaskItemInterface;
use App\Entity\Card;
use App\Entity\Equipment;
use App\Entity\Marking;

class EquipmentAdminController extends TaskAdminController
{
    function getEntityClass(): string
    {
        return Equipment::class;
    }

    /**
     * При завершении задачи, меняем статус карточек на в аренде
     *
     * @param TaskItemInterface|Equipment $taskItem
     * @param $newStatusId
     */
    protected function preChangeStatus(TaskItemInterface $taskItem, $newStatusId)
    {
        $isComplete = $newStatusId === Marking::STATUS_COMPLETE; // Задача завершена
        if ($isComplete) {
            $em = $this->getDoctrine()->getManager();
            $taskItem->getCards()->map(function (Card $card) use ($em) {
                $card->setStatus(CardStatusHelper::STATUS_RENT);
                $em->persist($card);
            });
        }
    }
}