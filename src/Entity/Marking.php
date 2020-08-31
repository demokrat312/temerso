<?php

namespace App\Entity;

use App\Classes\Listener\CreatedBy\CreatedByListenerInterface;
use App\Classes\Listener\Date\DateListenerInterface;
use App\Classes\Marking\TaskEntityTrait;
use App\Classes\Task\TaskItemInterface;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Маркировка
 *
 * @ORM\Entity(repositoryClass="App\Repository\MarkingRepository")
 */
class Marking implements DateListenerInterface, CreatedByListenerInterface, TaskItemInterface
{
    use TaskEntityTrait;

    const STATUS_SEND_EXECUTION = 1; // Отправлено на исполнение
    const STATUS_ACCEPT_EXECUTION = 2; // Принято на исполнение
    const STATUS_SAVE = 3; // Результаты сохранены локально (Отправить задание на проверку)
    const STATUS_COMPLETE = 4; // Выполнено полностью (Принять от Исполнителя)
    const STATUS_CREATED = 5; // Созданно (или отредактированно)
    const STATUS_REVISION = 6; // Отправленно на доработку (такие же функции как у "Принято на исполнение")

    const STATUS_TITLE = [
        self::STATUS_SEND_EXECUTION => 'Отправлено на исполнение',
        self::STATUS_ACCEPT_EXECUTION => 'Принято на исполнение',
        self::STATUS_SAVE => 'Отправлено на проверку', // Результаты сохранены локально
        self::STATUS_COMPLETE => 'Выполнено полностью',
        self::STATUS_CREATED => 'Создано', // Отредактированно
        self::STATUS_REVISION => 'Отправленно на доработку',
    ];

    const STATUS_ORDER = [
        self::STATUS_CREATED, // 5 - Созданно
        self::STATUS_SEND_EXECUTION, // 1 -  Отправлено на исполнение
        self::STATUS_ACCEPT_EXECUTION, // 2 -  Принято на исполнение
        self::STATUS_SAVE, // 3 -  Результаты сохранены локально
        self::STATUS_REVISION, // 6 -  Отправленно на доработку
        self::STATUS_COMPLETE, // 4 -  Выполнено полностью
    ];

    // Отображаем временные карточки только на этих статусах
    const STATUS_CARD_TEMPORARY = [
        self::STATUS_SEND_EXECUTION,
        self::STATUS_ACCEPT_EXECUTION,
        self::STATUS_SAVE
    ];

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

    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
