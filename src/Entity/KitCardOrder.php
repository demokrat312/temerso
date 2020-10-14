<?php

namespace App\Entity;

use App\Classes\Listener\Cards\CardsWithOrderListenerInterface;
use App\Classes\Listener\Cards\CardWithOrderInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Связь между "Комплекта для постановщика" и карточками для сортировку по порядку
 *
 * @ORM\Entity(repositoryClass="App\Repository\KitCardRepository")
 */
class KitCardOrder implements CardWithOrderInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Kit", inversedBy="kitCards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $kit;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Card")
     */
    private $card;

    /**
     * На всякий случай поле для сортировки
     * @ORM\Column(type="integer", nullable=true)
     */
    private $orderNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKit(): ?Kit
    {
        return $this->kit;
    }

    public function setKit(?Kit $kit): self
    {
        $this->kit = $kit;

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

    /**
     * @return mixed
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @param mixed $orderNumber
     * @return $this
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    public function setParent(CardsWithOrderListenerInterface $cardsWithOrderListener)
    {
        $this->setKit($cardsWithOrderListener);
    }
}
