<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-08-30
 * Time: 21:40
 */

namespace App\Form\Data\Api\Card;


class CardEditData
{
    /**
     * Ключ карточки
     *
     * @var int|null
     */
    private $id;
    /**
     * Ключ, задачи
     *
     * @var int|null
     */
    private $taskId;
    /**
     * Тип задачи
     *
     * @var int|null
     */
    private $taskTypeId;
    /**
     * Метки RFID
     *
     * @var string|null
     */
    private $rfidTagNo;
    /**
     * Учет/Инвентаризация
     *
     * @var integer|null
     */
    private $accounting;
    /**
     * Примечание
     *
     * @var string|null
     */
    private $comment;
    /**
     * Оборудование есть, проблема с меткой(для инспекции)
     *
     * @var string|null
     */
    private $commentProblemWithMark;

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
    public function getTaskId(): ?int
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
    public function getTaskTypeId(): ?int
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
    public function getAccounting()
    {
        return $this->accounting;
    }

    /**
     * @param mixed $accounting
     * @return $this
     */
    public function setAccounting($accounting)
    {
        $this->accounting = $accounting;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComment(): ?string
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
     * @return mixed
     */
    public function getCommentProblemWithMark(): ?string
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
}