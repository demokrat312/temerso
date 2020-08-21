<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-16
 * Time: 00:56
 */

namespace App\Form\Data\Api\Card;


class CardListAddToEquipmentData
{
    /**
     * @var integer|null
     */
    private $id;
    /**
     * @var CardAddToEquipmentData[]
     */
    private $list = [];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return CardAddToEquipmentData[]
     */
    public function getList(): array
    {
        return $this->list;
    }

    /**
     * @param CardAddToEquipmentData[] $list
     * @return $this
     */
    public function setList(array $list)
    {
        $this->list = $list;
        return $this;
    }
}