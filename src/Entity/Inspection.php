<?php

namespace App\Entity;

use App\Classes\Inspection\InspectionTrait;
use App\Classes\Listener\CreatedBy\CreatedByListenerInterface;
use App\Classes\Listener\Date\DateListenerInterface;
use App\Classes\Marking\TaskEntityTrait;
use App\Classes\Task\TaskItemInterface;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * 6) Инспекция/Дефектоскопия
 *
 * @ORM\Entity(repositoryClass="App\Repository\InspectionRepository")
 */
class Inspection implements DateListenerInterface, CreatedByListenerInterface, TaskItemInterface
{
    use TaskEntityTrait, InspectionTrait;
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
     * @ORM\OneToOne(targetEntity="App\Entity\ReturnFromRent", mappedBy="inspection", cascade={"persist", "remove"})
     */
    private $returnFromRent;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ReturnFromRepair", mappedBy="inspection", cascade={"persist", "remove"})
     */
    private $returnFromRepair;

    /**
     * Карточки
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\CardTemporary")
     */
    private $cardsTemporary;

    public function __construct()
    {
        $this->status = Marking::STATUS_CREATED;

        $this->cards = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->cardsTemporary = new ArrayCollection();
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
     * @return Collection|CardTemporary[]
     */
    public function getCardsTemporary(): Collection
    {
        return $this->cardsTemporary;
    }

    public function addCardTemporary(CardTemporary $cardTemporary): self
    {
        if (!$this->cardsTemporary->contains($cardTemporary)) {
            $this->cardsTemporary[] = $cardTemporary;
        }

        return $this;
    }

    public function removeCardTemporary(CardTemporary $cardTemporary): self
    {
        if ($this->cardsTemporary->contains($cardTemporary)) {
            $this->cardsTemporary->removeElement($cardTemporary);
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

    public function getReturnFromRent(): ?ReturnFromRent
    {
        return $this->returnFromRent;
    }

    public function setReturnFromRent(?ReturnFromRent $returnFromRent): self
    {
        $this->returnFromRent = $returnFromRent;

        // set (or unset) the owning side of the relation if necessary
        $newInspection = null === $returnFromRent ? null : $this;
        if ($returnFromRent->getInspection() !== $newInspection) {
            $returnFromRent->setInspection($newInspection);
        }

        return $this;
    }

    public function getReturnFromRepair(): ?ReturnFromRepair
    {
        return $this->returnFromRepair;
    }

    public function setReturnFromRepair(?ReturnFromRepair $returnFromRepair): self
    {
        $this->returnFromRepair = $returnFromRepair;

        // set (or unset) the owning side of the relation if necessary
        $newInspection = null === $returnFromRepair ? null : $this;
        if ($returnFromRepair->getInspection() !== $newInspection) {
            $returnFromRepair->setInspection($newInspection);
        }

        return $this;
    }
}
