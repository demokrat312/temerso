<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-08-04
 * Time: 10:33
 */

namespace App\Form\Data\Api\Kit;

use Symfony\Component\Validator\Constraints as Assert;


class KitData
{
    /**
     * Комментарий
     * @Assert\NotBlank(allowNull=true)
     *
     * @var string
     */
    private $comment;
    /**
     * Карточки
     *
     * @var KitCardsData[]
     * @Assert\Count(min=1, minMessage="Укажите хотя бы одну карточку")
     */
    private $cards = [];

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     * @return $this
     */
    public function setComment(?string $comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return KitCardsData[]
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * @param KitCardsData[] $cards
     * @return $this
     */
    public function setCards(array $cards)
    {
        $this->cards = $cards;
        return $this;
    }
}