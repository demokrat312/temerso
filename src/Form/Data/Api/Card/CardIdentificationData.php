<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-16
 * Time: 00:56
 */

namespace App\Form\Data\Api\Card;


class CardIdentificationData
{
    /**
     * @var int|null
     */
    private $pipeSerialNumber;
    /**
     * @var int|null
     */
    private $couplingSerialNumber;
    /**
     * @var int|null
     */
    private $serialNoOfNipple;
    /**
     * @var string|null
     */
    private $rfidTagNo;

    /**
     * @return int|null
     */
    public function getPipeSerialNumber(): ?int
    {
        return $this->pipeSerialNumber;
    }

    /**
     * @param int|null $pipeSerialNumber
     * @return $this
     */
    public function setPipeSerialNumber(?int $pipeSerialNumber)
    {
        $this->pipeSerialNumber = $pipeSerialNumber;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCouplingSerialNumber(): ?int
    {
        return $this->couplingSerialNumber;
    }

    /**
     * @param int|null $couplingSerialNumber
     * @return $this
     */
    public function setCouplingSerialNumber(?int $couplingSerialNumber)
    {
        $this->couplingSerialNumber = $couplingSerialNumber;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSerialNoOfNipple(): ?int
    {
        return $this->serialNoOfNipple;
    }

    /**
     * @param int|null $serialNoOfNipple
     * @return $this
     */
    public function setSerialNoOfNipple(?int $serialNoOfNipple)
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
}