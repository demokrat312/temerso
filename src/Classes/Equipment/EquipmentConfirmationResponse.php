<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-09-02
 * Time: 14:32
 */

namespace App\Classes\Equipment;

use App\Classes\ApiParentController;
use App\Entity\Card;
use App\Form\Data\Api\Equipment\ConfirmationCardsData;
use App\Form\Data\Api\Equipment\ConfirmationData;
use Symfony\Component\Serializer\Annotation\Groups;


class EquipmentConfirmationResponse
{
    /**
     * Ключ задачи
     * @var int
     * @Groups(ApiParentController::GROUP_API_DEFAULT)
     */
    private $taskId;
    /**
     * Подтвержденные карточки
     *
     * @var Card[]
     * @Groups(ApiParentController::GROUP_API_DEFAULT)
     */
    private $confirmed;
    /**
     * Неподтвержденные
     *
     * @var Card[]
     * @Groups(ApiParentController::GROUP_API_DEFAULT)
     */
    private $notConfirmed;

    /**
     * EquipmentConfirmationResponse constructor.
     * @param $taskId
     * @param $confirmed
     * @param $notConfirmed
     */
    public function __construct($taskId, $confirmed, $notConfirmed)
    {
        $this->taskId = $taskId;
        $this->confirmed = $confirmed;
        $this->notConfirmed = $notConfirmed;
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
     * @return Card[]
     */
    public function getConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @param mixed $confirmed
     * @return $this
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;
        return $this;
    }

    /**
     * @return Card[]
     */
    public function getNotConfirmed()
    {
        return $this->notConfirmed;
    }

    /**
     * @param mixed $notConfirmed
     * @return $this
     */
    public function setNotConfirmed($notConfirmed)
    {
        $this->notConfirmed = $notConfirmed;
        return $this;
    }
}