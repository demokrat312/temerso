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
     * @var float|null
     */
    private $pipeSerialNumber;
    /**
     * @var float|null
     */
    private $couplingSerialNumber;
    /**
     * @var float|null
     */
    private $serialNoOfNipple;
    /**
     * @var string|null
     */
    private $rfidTagNo;
    /**
     * @var int|null
     */
    private $accounting;

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
     * @return float|null
     */
    public function getPipeSerialNumber(): ?float
    {
        return $this->pipeSerialNumber;
    }

    /**
     * @param float|null $pipeSerialNumber
     * @return $this
     */
    public function setPipeSerialNumber(?float $pipeSerialNumber)
    {
        $this->pipeSerialNumber = $pipeSerialNumber;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getCouplingSerialNumber(): ?float
    {
        return $this->couplingSerialNumber;
    }

    /**
     * @param float|null $couplingSerialNumber
     * @return $this
     */
    public function setCouplingSerialNumber(?float $couplingSerialNumber)
    {
        $this->couplingSerialNumber = $couplingSerialNumber;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getSerialNoOfNipple(): ?float
    {
        return $this->serialNoOfNipple;
    }

    /**
     * @param float|null $serialNoOfNipple
     * @return $this
     */
    public function setSerialNoOfNipple(?float $serialNoOfNipple)
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
     * @return int|null
     */
    public function getAccounting(): ?int
    {
        return $this->accounting;
    }

    /**
     * @param int|null $accounting
     * @return $this
     */
    public function setAccounting(?int $accounting)
    {
        $this->accounting = $accounting;
        return $this;
    }
}