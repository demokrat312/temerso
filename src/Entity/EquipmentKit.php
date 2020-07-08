<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Групировка карточек для коплекта
 *
 * @ORM\Entity(repositoryClass="App\Repository\EquipmentKitRepository")
 */
class EquipmentKit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment", inversedBy="kits", cascade={"persist"})
     */
    private $equipment;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Card")
     */
    private $card;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\EquipmentKitSpecification", mappedBy="equipmentKit", cascade={"persist", "remove"})
     */
    private $specification;

    public function __construct()
    {
        $this->card = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(?Equipment $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * @return Collection|Card[]
     */
    public function getCard(): Collection
    {
        return $this->card;
    }

    public function addCard(Card $card): self
    {
        if (!$this->card->contains($card)) {
            $this->card[] = $card;
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->card->contains($card)) {
            $this->card->removeElement($card);
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSpecification(): ?EquipmentKitSpecification
    {
        return $this->specification;
    }

    public function setSpecification(?EquipmentKitSpecification $specification): self
    {
        $this->specification = $specification;

        // set (or unset) the owning side of the relation if necessary
        $newEquipmentKit = null === $specification ? null : $this;
        if ($specification->getEquipmentKit() !== $newEquipmentKit) {
            $specification->setEquipmentKit($newEquipmentKit);
        }

        return $this;
    }
}
