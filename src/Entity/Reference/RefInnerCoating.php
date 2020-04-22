<?php

namespace App\Entity\Reference;

use Doctrine\ORM\Mapping as ORM;

/**
 * 7)Внутреннее покрытие
 *
 * TC2000,
 * Без покрытия,
 * Другое (введите значение)
 *Также для администратора будет доступен функционал по внесению новых значений списка этой характеристики
 *
 * @ORM\Entity(repositoryClass="App\Repository\Reference\InnerCoatingRepository")
 */
class RefInnerCoating extends \App\Classes\ReferenceParent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
