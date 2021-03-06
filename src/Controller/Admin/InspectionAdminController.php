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
use App\Classes\Utils;
use App\Entity\Card;
use App\Entity\Inspection;
use App\Entity\Marking;

/**
 * 6) Инспекция/Дефектоскопия
 *
 * Class InspectionAdminController
 * @package App\Controller\Admin
 */
class InspectionAdminController extends TaskAdminController
{
    function getEntityClass(): string
    {
        return Inspection::class;
    }

    /**
     * @param TaskItemInterface|Inspection $taskItem
     * @param $newStatusId
     */
    protected function preChangeStatus(TaskItemInterface $taskItem, $newStatusId)
    {
        $isComplete = $newStatusId === Marking::STATUS_COMPLETE; // Задача завершена
        if ($isComplete) {
            // Меняем статус у карточек
            $em = $this->getDoctrine()->getManager();
            $taskItem->getCards()->map(function (Card $card) use ($em) {
                $card->setStatus(CardStatusHelper::STATUS_STORE);
                $em->persist($card);
            });
        }
    }
}