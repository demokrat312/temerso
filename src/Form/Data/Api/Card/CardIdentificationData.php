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
     * @return string|null
     */
    public function getPipeSerialNumber()
    {
        return $this->pipeSerialNumber;
    }

    /**
     * @param string|null $pipeSerialNumber
     * @return $this
     */
    public function setPipeSerialNumber($pipeSerialNumber)
    {
        $this->pipeSerialNumber = $pipeSerialNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCouplingSerialNumber()
    {
        return $this->couplingSerialNumber;
    }

    /**
     * @param string|null $couplingSerialNumber
     * @return $this
     */
    public function setCouplingSerialNumber($couplingSerialNumber)
    {
        $this->couplingSerialNumber = $couplingSerialNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSerialNoOfNipple()
    {
        return $this->serialNoOfNipple;
    }

    /**
     * @param string|null $serialNoOfNipple
     * @return $this
     */
    public function setSerialNoOfNipple($serialNoOfNipple)
    {
        $this->serialNoOfNipple = $serialNoOfNipple;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRfidTagNo()
    {
        return $this->rfidTagNo;
    }

    /**
     * @param string|null $rfidTagNo
     * @return $this
     */
    public function setRfidTagNo($rfidTagNo)
    {
        $this->rfidTagNo = $rfidTagNo;
        return $this;
    }
}