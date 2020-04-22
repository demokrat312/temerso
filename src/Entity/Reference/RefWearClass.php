<?php

namespace App\Entity\Reference;

use Doctrine\ORM\Mapping as ORM;

/**
 * 10)Класс износа
 *
 * Ultra - Ультра,
 * Premium - Премиум,
 * Premium, reduced TSR - Премиум со сниженным коэфициентом на кручение,
 * Class 2 - Класс 2,
 * Scrap - Брак окончательный
 *
 * @ORM\Entity(repositoryClass="App\Repository\Reference\WearClassRepository")
 */
class RefWearClass extends \App\Classes\ReferenceParent
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
