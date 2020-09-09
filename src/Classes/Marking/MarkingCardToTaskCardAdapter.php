<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 19.06.2020
 * Time: 11:49
 */

namespace App\Classes\Marking;

use App\Application\Sonata\MediaBundle\Entity\Media;
use App\Classes\Task\TaskItem;
use App\Entity\Card;
use App\Entity\Repair;

/**
 * Карточки из маркировки приводем к карточкам для задачи
 */
class MarkingCardToTaskCardAdapter
{
    public function getCard(Card $card, int $taskTypeId = null, int $taskId = null)
    {
        $taskCard = new TaskCard();

        $taskCard
            ->setId($card->getId())
            ->setFullName($card->getGeneralName())
            ->setPipeSerialNumber($card->getPipeSerialNumber())
            ->setSerialNoOfNipple($card->getSerialNoOfNipple())
            ->setCouplingSerialNumber($card->getCouplingSerialNumber())
            ->setRfidTagNo($card->getRfidTagNo())
            ->setAccounting($card->getAccounting())
//            ->setImages($card->getImages(Media::CONTEXT_CARD_INVENTORY))
            ->setImages($card->getImages())
            ->setTaskId($taskId);

        if($taskTypeId === TaskItem::TYPE_REPAIR && $taskId) {
            $taskCard->setCardImgRequired($card->getRepairCardImgRequiredByRepair($taskId)->getRequired());
        }

        if ($taskTypeId && $taskId) {
            $taskCard
                ->setComment($card->getTaskCardOtherFieldsByTask($taskTypeId, $taskId)->getComment())
                ->setCommentProblemWithMark($card->getTaskCardOtherFieldsByTask($taskTypeId, $taskId)->getCommentProblemWithMark())
                ->setTaskTypeId($taskTypeId);
        }


        return $taskCard;
    }
}