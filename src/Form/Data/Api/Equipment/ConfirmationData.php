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
use Symfony\Component\Validator\Constraints as Assert;

class ConfirmationData
{
    /**
     * Ключ задачи (Комплектация в аренду)
     *
     * @var int
     * @Groups(ApiParentController::GROUP_API_DEFAULT)
     * @Assert\NotBlank(message="Ключи задачи обезательное поле")
     * @Assert\Positive()
     */
    private $taskId;
    /**
     * Список карточек
     *
     * @var ConfirmationCardsData[]
     * @Groups(ApiParentController::GROUP_API_DEFAULT)
     */
    private $cards;

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
     * @return ConfirmationCardsData[]
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @param mixed $cards
     * @return $this
     */
    public function setCards($cards)
    {
        $this->cards = $cards;
        return $this;
    }
}