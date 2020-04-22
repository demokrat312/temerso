<?php

namespace App\Entity\Reference;

use Doctrine\ORM\Mapping as ORM;

/**
 * 20)Хардбендинг ниппель (состояние)
 *
 * Отсутствует,
 * В норме,
 * EW - эксцентричный износ,
 * SR - требует ремонт
 *
 * @ORM\Entity(repositoryClass="App\Repository\Reference\HardbendigNippleStateRepository")
 */
class RefHardbandingNippleState extends \App\Classes\ReferenceParent
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
