<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-09-02
 * Time: 14:03
 */

namespace App\Form\Data\Api\Equipment;


use App\Form\Type\Equipment\ConfirmationCardsType;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Classes\ApiParentController;

class ConfirmationCardsData
{
    /**
     * № Метки RFID
     *
     * @var string
     * @Groups(ApiParentController::GROUP_API_DEFAULT)
     */
    private $rfidTagNo;

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
}