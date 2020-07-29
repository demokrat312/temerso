<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Обезательная загрузка изображений для карточки
 *
 * @ORM\Entity(repositoryClass="App\Repository\RepairCardImgRequiredRepository")
 */
class RepairCardImgRequired
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Repair", inversedBy="cardImgRequired")
     * @ORM\JoinColumn(nullable=false)
     */
    private $repair;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Card", inversedBy="repairCardImgRequired")
     * @ORM\JoinColumn(nullable=false)
     */
    private $card;

    /**
     * @ORM\Column(type="boolean")
     */
    private $required;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepair(): ?Repair
    {
        return $this->repair;
    }

    public function setRepair(?Repair $repair): self
    {
        $this->repair = $repair;

        return $this;
    }

    public function getCard(): ?Card
    {
        return $this->card;
    }

    public function setCard(Card $card): self
    {
        $this->card = $card;

        return $this;
    }

    public function getRequired(): ?bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
    }
}
