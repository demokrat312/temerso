<?php

namespace App\Entity;

use App\Application\Sonata\MediaBundle\Entity\Media;
use App\Classes\Equipment\EquipmentTrait;
use App\Classes\Listener\CreatedBy\CreatedByListenerInterface;
use App\Classes\Listener\Date\DateListenerInterface;
use App\Classes\Marking\TaskEntityTrait;
use App\Classes\Task\RevisionInterface;
use App\Classes\Task\TaskItemInterface;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Classes\ApiParentController;

/**
 * Комплектация в аренду
 *
 * @ORM\Entity(repositoryClass="App\Repository\EquipmentRepository")
 */
class Equipment implements DateListenerInterface, CreatedByListenerInterface, TaskItemInterface, RevisionInterface
{
    use TaskEntityTrait, EquipmentTrait;

    const KIT_TYPE_SINGLE = 'single'; // Единичный комплект
    const KIT_TYPE_MULTI = 'multi'; // Множественный комплект

    const CATALOG_WITH = 'withCatalog'; // С выборкой из каталога
    const CATALOG_WITHOUT = 'withoutCatalog'; // Без выборки из каталога

    /**
     * Ключ
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     */
    private $id;

    /**
     * Основание формирования комплекта
     *
     * @ORM\Column(type="string", length=500)
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     */
    private $mainReason;

    /**
     * Приложения: Загрузить файлы (возможность подгрузки файлов)
     *
     * @ORM\ManyToMany(targetEntity="App\Application\Sonata\MediaBundle\Entity\Media",cascade={"persist"})
     */
    private $files;

    /**
     * Название компании-арендатора: Текстовый ввод пользователя
     *
     * @ORM\Column(type="string", length=255)
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     */
    private $tenantName;

    /**
     * Исполнитель
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\User")
     */
    private $users;

    /**
     * Дата создания задачи
     *
     * @ORM\Column(type="datetime")
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
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
     * Комментацрий
     *
     * @ORM\Column(type="text", nullable=true)
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * Комплекты
     *
     * @var EquipmentKit[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\EquipmentKit", mappedBy="equipment",cascade={"persist"})
     * @OrderBy({"id" = "ASC"})
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
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
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     */
    private $kitType;

    /**
     * Укажите количество единиц оборудования
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     */
    private $cardCount;

    /**
     * Укажите количество комплектов
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     */
    private $kitCount;

    /**
     * Укажите количество единиц оборудования в каждом из комплектов(через запятую)
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     */
    private $kitCardCount;

    /**
     * Каталог
     *
     * 'choices'  => [
     * 'С выборкой из каталога' => 'withCatalog',
     * 'Без выборки из каталога' => 'withoutCatalog',
     * ],
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     */
    private $withKit;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ReturnFromRent", mappedBy="equipment", cascade={"persist"})
     */
    private $returnFromRent;

    /**
     * Неподтвержденные карточки
     *
     * @var EquipmentCardsNotConfirmed[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\EquipmentCardsNotConfirmed", mappedBy="equipment",cascade={"persist", "remove"})
     */
    private $cardsNotConfirmed;

    /**
     * Поле нужно для очистки $over.
     * Если задачу отправять на "Отправленно на доработку", то в поле выставляем true,
     * при сохранении излишка, поле меняем на false и чистим старый излишек.
     *
     * @ORM\Column(type="boolean", options={"default" : "0"})
     */
    private $isRevision;

    public function __construct()
    {
        $this->status = Marking::STATUS_CREATED;
        $this->isRevision = false;

        $this->files = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->kits = new ArrayCollection();
        $this->cardsNotConfirmed = new ArrayCollection();

        $this->cardCount = 1;
        $this->kitCount = 1;
    }

    public function __toString()
    {
        return $this->getChoiceTitle();
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
        $cards = new ArrayCollection();
        $this->kits->map(function (EquipmentKit $equipmentKit) use (&$cards) {
            $cards = new ArrayCollection(array_merge($cards->toArray(), $equipmentKit->getCards()->toArray()));
        });

        return $cards;
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

    public function getReturnFromRent(): ?ReturnFromRent
    {
        return $this->returnFromRent;
    }

    public function setReturnFromRent(ReturnFromRent $returnFromRent): self
    {
        $this->returnFromRent = $returnFromRent;

        // set the owning side of the relation if necessary
        if ($returnFromRent->getEquipment() !== $this) {
            $returnFromRent->setEquipment($this);
        }

        return $this;
    }

    /**
     * @return Collection|EquipmentCardsNotConfirmed[]
     */
    public function getCardsNotConfirmed(): Collection
    {
        return $this->cardsNotConfirmed;
    }

    public function addCardsNotConfirmed(EquipmentCardsNotConfirmed $cardsNotConfirmed): self
    {
        if (!$this->cardsNotConfirmed->contains($cardsNotConfirmed)) {
            $this->cardsNotConfirmed[] = $cardsNotConfirmed;
            $cardsNotConfirmed->setEquipment($this);
        }

        return $this;
    }

    public function removeCardsNotConfirmed(EquipmentCardsNotConfirmed $cardsNotConfirmed): self
    {
        if ($this->cardsNotConfirmed->contains($cardsNotConfirmed)) {
            $this->cardsNotConfirmed->removeElement($cardsNotConfirmed);
            // set the owning side to null (unless already changed)
            if ($cardsNotConfirmed->getEquipment() === $this) {
                $cardsNotConfirmed->setEquipment(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsRevision()
    {
        return $this->isRevision;
    }

    /**
     * @param mixed $isRevision
     * @return $this
     */
    public function setIsRevision($isRevision)
    {
        $this->isRevision = $isRevision;
        return $this;
    }
}
