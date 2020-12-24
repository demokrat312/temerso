<?php

namespace App\Entity;

use App\Classes\Equipment\EquipmentKitTrait;
use App\Classes\Listener\Cards\CardsOrderListenerInterface;
use App\Classes\Listener\Cards\CardsOrderTrait;
use App\Classes\Utils;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Classes\ApiParentController;


/**
 * Групировка карточек для коплекта
 *
 * @ORM\Entity(repositoryClass="App\Repository\EquipmentKitRepository")
 */
class EquipmentKit implements CardsOrderListenerInterface
{
    use CardsOrderTrait, EquipmentKitTrait;

    /**
     * Ключ
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment", inversedBy="kits", cascade={"persist"})
     */
    private $equipment;

    /**
     * Карточки
     *
     * @var Card[]
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Card")
     * @OrderBy({"id" = "ASC"})
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     */
    private $cards;

    /**
     * Название комплекта
     *
     * @ORM\Column(type="string", length=255)
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     */
    private $title;

    /**
     * Характеристики
     *
     * @var EquipmentKitSpecification
     *
     * @ORM\OneToOne(targetEntity="App\Entity\EquipmentKitSpecification", mappedBy="equipmentKit", cascade={"persist", "remove"})
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     */
    private $specification;

    /**
     * Излишек/Не найденные карточки
     *
     * @var EquipmentOver[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\EquipmentOver", mappedBy="equipmentKit", cascade={"persist", "remove"})
     */
    private $over;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
        $this->over = new ArrayCollection();
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
    public function getCards(): Collection
    {
        return Utils::filterDuplicate($this->getCardsWithOrder());
    }

    /**
     * @return Collection|Card[]
     */
    public function getCard(): Collection
    {
        return $this->cards;
    }

    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
        }

        return $this;
    }

    /**
     * @return Collection|EquipmentOver[]
     */
    public function getOver(): Collection
    {
        return Utils::filterDuplicate($this->over);
    }

    public function addOver(EquipmentOver $over): self
    {
        if (!$this->over->contains($over)) {
            $this->over[] = $over;
        }

        return $this;
    }

    public function clearOver()
    {
        $this->over->clear();
    }

    public function removeOver(EquipmentOver $over): self
    {
        if ($this->over->contains($over)) {
            $this->over->removeElement($over);
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
