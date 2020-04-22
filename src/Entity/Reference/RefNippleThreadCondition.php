<?php

namespace App\Entity\Reference;

use Doctrine\ORM\Mapping as ORM;

/**
 * 17)Состояние резьбы ниппеля
 *
 * NDF (В норме),
 * W (Промыв),
 * TD (Повреждение резьбы),
 * Tcorr (Коррозия резьбы),
 * MD  (Механическое повреждение)
 *
 * @ORM\Entity(repositoryClass="App\Repository\Reference\NippleThreadConditionRepository")
 */
class RefNippleThreadCondition extends \App\Classes\ReferenceParent
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
