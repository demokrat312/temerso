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

/**
 * Карточки из маркировки приводем к карточкам для задачи
 */
class MarkingCardToTaskCardAdapter
{
    public function getCard(Card $card, string $entityClass, int $taskId = null)
    {
        $taskCard = new TaskCard();

        $taskCard
            ->setId($card->getId())
            ->setFullName($card->getGeneralName())
            ->setPipeSerialNumber($card->getPipeSerialNumber())
            ->setSerialNoOfNipple($card->getSerialNoOfNipple())
            ->setCouplingSerialNumber($card->getCouplingSerialNumber())
            ->setRfidTagNo($card->getRfidTagNo())
            ->setComment($card->getTaskCardOtherFieldsByTask(new $entityClass())->getComment())
            ->setCommentProblemWithMark($card->getTaskCardOtherFieldsByTask(new $entityClass())->getCommentProblemWithMark())
            ->setAccounting($card->getAccounting())
            ->setImages($card->getImages(Media::CONTEXT_CARD_INVENTORY))
            ->setTaskId($taskId)
            ->setTaskTypeId(TaskItem::TYPE_BY_CLASS[$entityClass])
            ;


        return $taskCard;
    }
}