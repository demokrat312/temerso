<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-08-09
 * Time: 15:41
 */

namespace App\Form\Data\Api\Card;

use Symfony\Component\Validator\Constraints as Assert;


class CardListEditData
{
    /**
     * Список карточек
     *
     * @var CardEditData[]
     *
     * @Assert\Count(min = 1, minMessage = "Задайте хотябы одну карточку")
     * @Assert\Valid()
     */
    private $list;

    /**
     * @return CardEditData[]
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * @param mixed $list
     * @return $this
     */
    public function setList($list)
    {
        $this->list = $list;

        return $this;
    }
}