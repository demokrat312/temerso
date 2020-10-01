<?php

namespace App\Entity;

use App\Classes\Listener\Cards\CardsOrderListenerInterface;
use App\Classes\Listener\Cards\CardsOrderTrait;
use App\Classes\Listener\CreatedBy\CreatedByListenerInterface;
use App\Classes\Listener\Date\DateListenerInterface;
use App\Classes\Marking\TaskEntityTrait;
use App\Classes\Task\TaskItemInterface;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * 5. Инвентаризация
 *
 * @ORM\Entity(repositoryClass="App\Repository\InventoryRepository")
 */
class Inventory implements DateListenerInterface, CreatedByListenerInterface, TaskItemInterface, CardsOrderListenerInterface
{
    use TaskEntityTrait, CardsOrderTrait;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Card")
     * @OrderBy({"id" = "ASC"})
     */
    private $cards;

    /**
     * @Assert\Count(min = 1, minMessage = "Выберите исполнителя")
     * @ORM\ManyToMany(targetEntity="App\Entity\User")
     */
    private $users;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * Излишек
     *
     * @ORM\OneToMany(targetEntity="App\Entity\InventoryOver", mappedBy="inventory", cascade={"persist", "remove"})
     */
    private $over;

    public function __construct()
    {
        $this->status = Marking::STATUS_CREATED;

        $this->cards = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->over = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Card[]
     */
    public function getCards(): Collection
    {
        return $this->getCardsWithOrder();;
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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    public function getCreateAt(): ?DateTimeInterface
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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

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

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return Collection|InventoryOver[]
     */
    public function getOver(): Collection
    {
        return $this->over;
    }

    public function addOver(InventoryOver $over): self
    {
        if (!$this->over->contains($over)) {
            $this->over[] = $over;
            $over->setInventory($this);
        }

        return $this;
    }

    public function removeOver(InventoryOver $over): self
    {
        if ($this->over->contains($over)) {
            $this->over->removeElement($over);
            // set the owning side to null (unless already changed)
            if ($over->getInventory() === $this) {
                $over->setInventory(null);
            }
        }

        return $this;
    }
}
