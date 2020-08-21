<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-08-21
 * Time: 23:11
 */

namespace App\Classes\Equipment;


class EquipmentErrorResponse
{
    /**
     * Сообщение об ошибке
     *
     * @var string
     */
    private $message;
    /**
     * Список карточек из-за которых произошла ошибка
     *
     * @var string[]
     */
    private $cardListError = [];

    /**
     * @return string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getCardListError(): array
    {
        return $this->cardListError;
    }

    /**
     * @param string[] $cardListError
     * @return $this
     */
    public function setCardListError(array $cardListError)
    {
        $this->cardListError = $cardListError;
        return $this;
    }
}