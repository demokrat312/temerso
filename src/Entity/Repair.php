<?php

namespace App\Entity;

use App\Classes\Listener\CreatedBy\CreatedByListenerInterface;
use App\Classes\Listener\Date\DateListenerInterface;
use App\Classes\Marking\TaskEntityTrait;
use App\Classes\Repair\RepairTrait;
use App\Classes\Task\TaskItemInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * 9. Комплектация в ремонт
 *
 * @ORM\Entity(repositoryClass="App\Repository\RepairRepository")
 */
class Repair implements  DateListenerInterface, CreatedByListenerInterface, TaskItemInterface
{
    use TaskEntityTrait, RepairTrait;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Card")
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
     * @ORM\OneToMany(targetEntity="App\Entity\RepairCardImgRequired", mappedBy="repair", cascade={"persist", "remove"})
     */
    private $cardImgRequired;

    public function __construct()
    {
        $this->status = Marking::STATUS_CREATED;
        $this->cards = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->cardImgRequired = new ArrayCollection();
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

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
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
     * @return Collection|RepairCardImgRequired[]
     */
    public function getCardImgRequired(): Collection
    {
        return $this->cardImgRequired;
    }

    public function addCardImgRequired(RepairCardImgRequired $cardImgRequired): self
    {
        if (!$this->cardImgRequired->contains($cardImgRequired)) {
            $this->cardImgRequired[] = $cardImgRequired;
            $cardImgRequired->setRepair($this);
        }

        return $this;
    }

    public function removeCardImgRequired(RepairCardImgRequired $cardImgRequired): self
    {
        if ($this->cardImgRequired->contains($cardImgRequired)) {
            $this->cardImgRequired->removeElement($cardImgRequired);
            // set the owning side to null (unless already changed)
            if ($cardImgRequired->getRepair() === $this) {
                $cardImgRequired->setRepair(null);
            }
        }

        return $this;
    }
}
