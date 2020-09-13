<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-09-13
 * Time: 13:40
 */

namespace App\Form\Data\Api\Card;

use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;


class CardImageListData
{
    /**
     * Ключ задачи
     *
     * @var integer
     * @Assert\NotBlank(allowNull=true)
     */
    private $taskId;

    /**
     * Тип родительской задачи
     *
     * @var integer
     * @Assert\NotBlank(allowNull=true)
     */
    private $taskTypeId;

    /**
     * Карточки
     *
     * @var CardImageListItemData[]
     * @Assert\Count(min="1")
     */
    private $cards = [];

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
     * @return CardImageListItemData[]
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @param CardImageListItemData $cards
     * @return $this
     */
    public function setCards($cards)
    {
        $this->cards = $cards;
        return $this;
    }
}