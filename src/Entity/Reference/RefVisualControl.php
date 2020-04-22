<?php

namespace App\Entity\Reference;

use Doctrine\ORM\Mapping as ORM;

/**
 * 11)Визуальный контроль состояния внутреннего покрытия
 *
 * Класс 1 (Class 1) - нет видимых потерь, незначительные истирания покрытия;
 * Класс 2 (Class 2) - полная потеря покрытия на участке ≤ 20%;
 * Класс 3 (Class 3) - > 20% и ≤ 35% потери покрытия, может присутствовать подплёночная коррозия;
 * Класс 4 (Class 4) - > 35%, могут присутствовать вспучивание, расслоение, подплёночная коррозия
 *
 * @ORM\Entity(repositoryClass="App\Repository\Reference\VisualControlRepository")
 */
class RefVisualControl extends \App\Classes\ReferenceParent
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
