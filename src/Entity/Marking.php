<?php

namespace App\Entity;

use App\Classes\DateListenerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MarkingRepository")
 * @ORM\EntityListeners({"App\EventListener\DateListener"})
 */
class Marking implements DateListenerInterface
{
    const STATUS_SEND_EXECUTION = 1; // Отправлено на исполнение
    const STATUS_ACCEPT_EXECUTION = 2; // Принято на исполнение
    const STATUS_SAVE = 3; // Результаты сохранены локально
    const STATUS_COMPLETE = 4; // Выполнено полностью
    const STATUS_CREATED = 5; // Созданно

    const STATUS_TITLE = [
        self::STATUS_SEND_EXECUTION => 'Отправлено на исполнение',
        self::STATUS_ACCEPT_EXECUTION => 'Принято на исполнение',
        self::STATUS_SAVE => 'Результаты сохранены локально',
        self::STATUS_COMPLETE => 'Выполнено полностью',
    ];

    const STATUS_ORDER = [
        self::STATUS_CREATED, // 5 - Созданно
        self::STATUS_SEND_EXECUTION, // 1 -  Отправлено на исполнение
        self::STATUS_ACCEPT_EXECUTION, // 2 -  Принято на исполнение
        self::STATUS_SAVE, // 3 -  Результаты сохранены локально
        self::STATUS_COMPLETE, // 4 -  Выполнено полностью
    ];

    const SINGLE_USER = false;

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

    public function __construct()
    {
        $this->status = self::STATUS_CREATED;

        $this->cards = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function addCard($card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
        }

        return $this;
    }

    public function removeCard($card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers()
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

    public function getStatusTitle()
    {
        return self::STATUS_TITLE[$this->status];
    }
}
