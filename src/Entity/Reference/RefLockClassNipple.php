<?php

namespace App\Entity\Reference;

use Doctrine\ORM\Mapping as ORM;

/**
 * 21)Класс замка ниппель
 *
 * Ultra - Ультра,
 * Premium - Премиум,
 * Class 2 - Класс 2,
 * EW - эксцентричный износ,
 * REJ - требует ремонт (перенарезка),
 * RF - требует ремонт (перешлифовка),
 * RB - nребует ремонт (фаска),
 * Scrap - окончательный брак
 *
 * @ORM\Entity(repositoryClass="App\Repository\Reference\LockClassNippleRepository")
 */
class RefLockClassNipple extends \App\Classes\Reference\ReferenceParent
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
