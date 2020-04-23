<?php

namespace App\Entity\Reference;

use Doctrine\ORM\Mapping as ORM;

/**
 * 16)Контроль шага резьбы ниппеля плоским шаблоном
 *
 * В норме,
 * ODT (Выход за пределы допусков)
 *
 * @ORM\Entity(repositoryClass="App\Repository\Reference\NippleThreadRepository")
 */
class RefNippleThread extends \App\Classes\Reference\ReferenceParent
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
