<?php

namespace App\Entity\Reference;

use Doctrine\ORM\Mapping as ORM;

/**
 * 8)Хардбендинг (ниппель)
 *
 * Интерпро VP-58,
 * Castolin OTW-12Ti,
 * TCS Titanium,
 * Duraband NC,
 * Arnco 350XT,
 * BoTn 3000,
 * Без наплавок,
 * Другое (введите значение)
 *Также для администратора будет доступен функционал по внесению новых значений списка этой характеристики
 *
 * @ORM\Entity(repositoryClass="App\Repository\Reference\HardbandingNippleRepository")
 */
class RefHardbandingNipple extends \App\Classes\ReferenceParent
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
