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


class CardImageListItemData
{
    /**
     * Ключ карточки
     *
     * @var integer
     * @Assert\NotBlank(allowNull=false)
     */
    private $cardId;

    /**
     * Изображение
     *
     * @var string[]
     *
     * @Assert\NotBlank()
     */
    private $images = [];

    /**
     * @return int|null
     */
    public function getCardId(): ?int
    {
        return $this->cardId;
    }

    /**
     * @param int|null $cardId
     * @return $this
     */
    public function setCardId(?int $cardId)
    {
        $this->cardId = $cardId;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param string[] $images
     * @return $this
     */
    public function setImages(array $images)
    {
        $this->images = $images;
        return $this;
    }
}