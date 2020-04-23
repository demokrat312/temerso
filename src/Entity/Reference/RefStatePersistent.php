<?php

namespace App\Entity\Reference;

use Doctrine\ORM\Mapping as ORM;

/**
 * 18)Состояние упорных торцев ниппеля
 *
 * В норме,
 * SD - повреждение упорных торцев,
 * Scorr - коррозия упорных торцев
 *
 * @ORM\Entity(repositoryClass="App\Repository\Reference\StatePersistentRepository")
 */
class RefStatePersistent extends \App\Classes\Reference\ReferenceParent
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
