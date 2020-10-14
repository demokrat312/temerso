<?php

namespace App\Entity;

use App\Classes\Kit\KitTrait;
use App\Classes\Listener\Cards\CardsOrderListenerInterface;
use App\Classes\Listener\Cards\CardsOrderTrait;
use App\Classes\Listener\Cards\CardsWithOrderListenerInterface;
use App\Classes\Listener\Cards\CardsWithOrderTrait;
use App\Classes\Listener\CreatedBy\CreatedByListenerInterface;
use App\Classes\Listener\Date\DateListenerInterface;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use Metadata\Tests\Driver\Fixture\A\A;

/**
 * Комплект
 * 11 ПРОЦЕСС, ВСПОМОГАТЕЛЬНЫЙ. ФОРМИРОВАНИЕ КОМПЛЕКТА ДЛЯ ПОСТАНОВЩИКА ЗАДАЧИ
 *
 * @ORM\Entity(repositoryClass="App\Repository\KitRepository")
 */
class Kit implements DateListenerInterface, CreatedByListenerInterface, CardsWithOrderListenerInterface
{
    use KitTrait, CardsWithOrderTrait;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @OrderBy({"id" = "ASC"})
     * @ORM\OneToMany(targetEntity="KitCardOrder", mappedBy="kit", cascade={"persist", "remove"})
     */
    private $cardsWithOrder;

    public function __toString()
    {
        return $this->getCreateAt()->format('d.m.Y') . ' ' .  $this->getCreatedBy()->getUsername();
    }


    public function __construct()
    {
        $this->cardsWithOrder = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreateAt(): DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection|KitCardOrder[]
     */
    public function getCardsWithOrder(): Collection
    {
        return $this->cardsWithOrder;
    }

    public function addKitCard(KitCardOrder $kitCard): self
    {
        if (!$this->cardsWithOrder->contains($kitCard)) {
            $this->cardsWithOrder[] = $kitCard;
            $kitCard->setKit($this);
        }

        return $this;
    }

    public function removeKitCard(KitCardOrder $kitCard): self
    {
        if ($this->cardsWithOrder->contains($kitCard)) {
            $this->cardsWithOrder->removeElement($kitCard);
            // set the owning side to null (unless already changed)
            if ($kitCard->getKit() === $this) {
                $kitCard->setKit(null);
            }
        }

        return $this;
    }

    public function addCard(Card $card)
    {
        $this->addKitCard((new KitCardOrder())->setCard($card));
    }
}
