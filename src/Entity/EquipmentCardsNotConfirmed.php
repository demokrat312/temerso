<?php

namespace App\Entity;

use App\Application\Sonata\MediaBundle\Entity\Media;
use App\Classes\Equipment\EquipmentTrait;
use App\Classes\Listener\CreatedBy\CreatedByListenerInterface;
use App\Classes\Listener\Date\DateListenerInterface;
use App\Classes\Marking\TaskEntityTrait;
use App\Classes\Task\TaskItemInterface;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Classes\ApiParentController;
/**
 * Комплектация в аренду. Неподтвержденные карточки
 *
 * @ORM\Entity(repositoryClass="App\Repository\EquipmentCardsNotConfirmedRepository")
 */
class EquipmentCardsNotConfirmed
{
    /**
     * Ключ
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipment", inversedBy="cardsNotConfirmed", cascade={"persist"})
     */
    private $equipment;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Card", cascade={"persist"})
     */
    private $card;

    /**
     * @return int
     */
    public function getId(): int
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
     * @return Card
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param mixed $card
     * @return $this
     */
    public function setCard($card)
    {
        $this->card = $card;
        return $this;
    }

}
