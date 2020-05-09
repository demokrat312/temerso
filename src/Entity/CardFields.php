<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CardFieldsRepository")
 */
class CardFields
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CardFieldsOption")
     * @ORM\JoinColumn(nullable=false)
     */
    private $field;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Card", inversedBy="cardFields")
     * @ORM\JoinColumn(nullable=false)
     */
    private $card;

    public function __toString()
    {
        return $this->getValue();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getField(): ?CardFieldsOption
    {
        return $this->field;
    }

    public function setField(?CardFieldsOption $field): self
    {
        $this->field = $field;

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

    public function getCard(): ?Card
    {
        return $this->card;
    }

    public function setCard(?Card $card): self
    {
        $this->card = $card;

        return $this;
    }
}
