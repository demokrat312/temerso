<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-16
 * Time: 00:56
 */

namespace App\Form\Data\Api\Card;


class CardAddToEquipmentData
{
    /**
     * @var integer
     */
    private $id;
    /**
     * @var string|null
     */
    private $pipeSerialNumber;
    /**
     * @var string|null
     */
    private $couplingSerialNumber;
    /**
     * @var string|null
     */
    private $serialNoOfNipple;
    /**
     * @var string|null
     */
    private $rfidTagNo;
    /**
     * @var string|null
     */
    private $comment;
    /**
     * @var string|null
     */
    private $commentProblemWithMark;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPipeSerialNumber(): ?string
    {
        return $this->pipeSerialNumber;
    }

    /**
     * @param string|null $pipeSerialNumber
     * @return $this
     */
    public function setPipeSerialNumber(?string $pipeSerialNumber)
    {
        $this->pipeSerialNumber = $pipeSerialNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCouplingSerialNumber(): ?string
    {
        return $this->couplingSerialNumber;
    }

    /**
     * @param string|null $couplingSerialNumber
     * @return $this
     */
    public function setCouplingSerialNumber(?string $couplingSerialNumber)
    {
        $this->couplingSerialNumber = $couplingSerialNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSerialNoOfNipple(): ?string
    {
        return $this->serialNoOfNipple;
    }

    /**
     * @param string|null $serialNoOfNipple
     * @return $this
     */
    public function setSerialNoOfNipple(?string $serialNoOfNipple)
    {
        $this->serialNoOfNipple = $serialNoOfNipple;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRfidTagNo(): ?string
    {
        return $this->rfidTagNo;
    }

    /**
     * @param string|null $rfidTagNo
     * @return $this
     */
    public function setRfidTagNo(?string $rfidTagNo)
    {
        $this->rfidTagNo = $rfidTagNo;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     * @return $this
     */
    public function setComment(?string $comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCommentProblemWithMark(): ?string
    {
        return $this->commentProblemWithMark;
    }

    /**
     * @param string|null $commentProblemWithMark
     * @return $this
     */
    public function setCommentProblemWithMark(?string $commentProblemWithMark)
    {
        $this->commentProblemWithMark = $commentProblemWithMark;
        return $this;
    }
}