<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-08-06
 * Time: 17:47
 */

namespace App\Classes\Card;


use App\Entity\Card;
use Symfony\Component\Serializer\Annotation\Groups;

class CardIdentificationResponse
{
    const GROUP_API_DEFAULT = 'identification';
    /**
     * Список карточек. Пустой если найдена только одна карточка
     *
     * @var Card[]
     * @Groups({CardIdentificationResponse::GROUP_API_DEFAULT})
     */
    private $cardList;
    /**
     * Карточка. Поле пустое если найдено несколько карточек
     * @var Card
     * @Groups({CardIdentificationResponse::GROUP_API_DEFAULT})
     */
    private $card;
    /**
     * Если несколько карточек то true
     *
     * @var boolean
     * @Groups({CardIdentificationResponse::GROUP_API_DEFAULT})
     */
    private $multiple;

    /**
     * @return Card[]
     */
    public function getCardList(): array
    {
        return $this->cardList;
    }

    /**
     * @param Card[] $cardList
     * @return $this
     */
    public function setCardList(array $cardList)
    {
        $this->cardList = $cardList;
        return $this;
    }

    /**
     * @return Card|null
     */
    public function getCard(): ?Card
    {
        return $this->card;
    }

    /**
     * @param Card|null $card
     * @return $this
     */
    public function setCard(?Card $card)
    {
        $this->card = $card;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMultiple(): bool
    {
        return $this->multiple;
    }

    /**
     * @param bool $multiple
     * @return $this
     */
    public function setMultiple(bool $multiple)
    {
        $this->multiple = $multiple;
        return $this;
    }
}