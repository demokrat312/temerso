<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Дополнительные поля для карточки настройки
 *
 * @ORM\Entity(repositoryClass="App\Repository\CardFieldsOptionRepository")
 */
class CardFieldsOption
{
    const TYPE_FLOAT = 1;
    const TYPE_STRING = 2;
    const TYPE_LIST = 3;

    const TYPE_TITLE = [
        self::TYPE_FLOAT => 'число',
        self::TYPE_STRING => 'строка',
        self::TYPE_LIST => 'список',
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Название поля
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * тип поля
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * Значение для выподающего списка
     * @ORM\Column(type="text", nullable=true)
     */
    private $value;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getTypeTitle()
    {
        return self::TYPE_TITLE[$this->type];
    }
}
