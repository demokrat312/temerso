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

/**
 * Комплектация в аренду
 *
 * @ORM\Entity(repositoryClass="App\Repository\EquipmentRepository")
 */
class Equipment implements DateListenerInterface, CreatedByListenerInterface, TaskItemInterface
{
    use TaskEntityTrait, EquipmentTrait;

    const KIT_TYPE_SINGLE = 'single'; // Единичный комплект
    const KIT_TYPE_MULTI = 'multi'; // Множественный комплект

    const CATALOG_WITH = 'withCatalog'; // С выборкой из каталога
    const CATALOG_WITHOUT = 'withoutCatalog'; // Без выборки из каталога

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Основание формирования комплекта
     *
     * @ORM\Column(type="string", length=500)
     */
    private $mainReason;

    /**
     * Приложения: Загрузить файлы (возможность подгрузки файлов)
     *
     * @ORM\ManyToMany(targetEntity="App\Application\Sonata\MediaBundle\Entity\Media")
     */
    private $files;

    /**
     * Название компании-арендатора: Текстовый ввод пользователя
     *
     * @ORM\Column(type="string", length=255)
     */
    private $tenantName;

    /**
     * Карточки
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Card")
     */
    private $cards;

    /**
     * Исполнитель
     *
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
     * @ORM\OneToMany(targetEntity="App\Entity\EquipmentKit", mappedBy="equipment",cascade={"persist"})
     */
    private $kits;

    /**
     * Выбрать тип комплекта
     *
     * 'choices'  => [
     * 'Единичный комплект' => 'single',
     * 'Множественный комплект' => 'multi',
     * ],
     *
     *
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $kitType;

    /**
     * Укажите количество единиц оборудования
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cardCount;

    /**
     * Укажите количество комплектов
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $kitCount;

    /**
     * Укажите количество единиц оборудования в каждом из комплектов(через запятую)
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $kitCardCount;

    /**
     * Каталог
     * 'choices'  => [
     * 'С выборкой из каталога' => 'withCatalog',
     * 'Без выборки из каталога' => 'withoutCatalog',
     * ],
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $withKit;

    public function __construct()
    {
        $this->status = Marking::STATUS_CREATED;

        $this->files = new ArrayCollection();
        $this->cards = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->kits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMainReason(): ?string
    {
        return $this->mainReason;
    }

    public function setMainReason(string $mainReason): self
    {
        $this->mainReason = $mainReason;

        return $this;
    }

    /**
     * @return Collection|Media[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(Media $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
        }

        return $this;
    }

    public function removeFile(Media $file): self
    {
        if ($this->files->contains($file)) {
            $this->files->removeElement($file);
        }

        return $this;
    }

    public function getTenantName(): ?string
    {
        return $this->tenantName;
    }

    public function setTenantName(string $tenantName): self
    {
        $this->tenantName = $tenantName;

        return $this;
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
     * @return Collection|EquipmentKit[]
     */
    public function getKits(): Collection
    {
        return $this->kits;
    }

    public function addKit(EquipmentKit $kit): self
    {
        if (!$this->kits->contains($kit)) {
            $this->kits[] = $kit;
            $kit->setEquipment($this);
        }

        return $this;
    }

    public function removeKit(EquipmentKit $kit): self
    {
        if ($this->kits->contains($kit)) {
            $this->kits->removeElement($kit);
            // set the owning side to null (unless already changed)
            if ($kit->getEquipment() === $this) {
                $kit->setEquipment(null);
            }
        }

        return $this;
    }

    public function getKitType(): ?string
    {
        return $this->kitType;
    }

    public function setKitType(?string $kitType): self
    {
        $this->kitType = $kitType;

        return $this;
    }

    public function getCardCount(): ?int
    {
        return $this->cardCount;
    }

    public function setCardCount(?int $cardCount): self
    {
        $this->cardCount = $cardCount;

        return $this;
    }

    public function getKitCount(): ?int
    {
        return $this->kitCount;
    }

    public function setKitCount(?int $kitCount): self
    {
        $this->kitCount = $kitCount;

        return $this;
    }

    public function getKitCardCount(): ?string
    {
        return $this->kitCardCount;
    }

    public function setKitCardCount(?string $kitCardCount): self
    {
        $this->kitCardCount = $kitCardCount;

        return $this;
    }

    public function getWithKit(): ?string
    {
        return $this->withKit;
    }

    public function setWithKit(?string $withKit): self
    {
        $this->withKit = $withKit;

        return $this;
    }
}
