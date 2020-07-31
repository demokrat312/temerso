<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 19.06.2020
 * Time: 11:49
 */

namespace App\Classes\Marking;


use App\Classes\MediaHelper;
use Doctrine\Common\Collections\Collection;

/**
 * Карточка для задачи
 */
class TaskCard
{
    private $id;
    private $fullName;
    private $pipeSerialNumber;
    private $serialNoOfNipple;
    private $couplingSerialNumber;
    private $rfidTagNo;
    private $comment;
    private $commentProblemWithMark;
    private $images;
    private $taskId;
    private $taskTypeId;
    private $cardImgRequired;
    /**
     * Учет/Инвентаризация. По умолчанию у создаваемых карточек будет проставляться 1.
     * @var int
     */
    private $accounting;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param mixed $fullName
     * @return $this
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPipeSerialNumber()
    {
        return $this->pipeSerialNumber;
    }

    /**
     * @param mixed $pipeSerialNumber
     * @return $this
     */
    public function setPipeSerialNumber($pipeSerialNumber)
    {
        $this->pipeSerialNumber = $pipeSerialNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSerialNoOfNipple()
    {
        return $this->serialNoOfNipple;
    }

    /**
     * @param mixed $serialNoOfNipple
     * @return $this
     */
    public function setSerialNoOfNipple($serialNoOfNipple)
    {
        $this->serialNoOfNipple = $serialNoOfNipple;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCouplingSerialNumber()
    {
        return $this->couplingSerialNumber;
    }

    /**
     * @param mixed $couplingSerialNumber
     * @return $this
     */
    public function setCouplingSerialNumber($couplingSerialNumber)
    {
        $this->couplingSerialNumber = $couplingSerialNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRfidTagNo()
    {
        return $this->rfidTagNo;
    }

    /**
     * @param mixed $rfidTagNo
     * @return $this
     */
    public function setRfidTagNo($rfidTagNo)
    {
        $this->rfidTagNo = $rfidTagNo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return int
     */
    public function getAccounting(): int
    {
        return $this->accounting;
    }

    /**
     * @param int $accounting
     * @return $this
     */
    public function setAccounting(int $accounting)
    {
        $this->accounting = $accounting;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommentProblemWithMark()
    {
        return $this->commentProblemWithMark;
    }

    /**
     * @param mixed $commentProblemWithMark
     * @return $this
     */
    public function setCommentProblemWithMark($commentProblemWithMark)
    {
        $this->commentProblemWithMark = $commentProblemWithMark;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param mixed $images
     * @return $this
     */
    public function setImages(Collection $images = null)
    {
        $this->images = MediaHelper::ins()->getImageLink($images);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaskId()
    {
        return $this->taskId;
    }

    /**
     * @param mixed $taskId
     * @return $this
     */
    public function setTaskId($taskId)
    {
        $this->taskId = $taskId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaskTypeId()
    {
        return $this->taskTypeId;
    }

    /**
     * @param mixed $taskTypeId
     * @return $this
     */
    public function setTaskTypeId($taskTypeId)
    {
        $this->taskTypeId = $taskTypeId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCardImgRequired()
    {
        return $this->cardImgRequired;
    }

    /**
     * @param mixed $cardImgRequired
     * @return $this
     */
    public function setCardImgRequired($cardImgRequired)
    {
        $this->cardImgRequired = $cardImgRequired;
        return $this;
    }
}