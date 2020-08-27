<?php

namespace App\Entity;

use App\Classes\Listener\CreatedBy\CreatedByListenerInterface;
use App\Classes\Listener\Date\DateListenerInterface;
use App\Classes\ReturnFromRent\ReturnFromRentTrait;
use App\Classes\Task\TaskItemInterface;
use Doctrine\ORM\Mapping as ORM;
// не удалять, какой то баг со вложенным trait
use /** @noinspection PhpUnusedAliasInspection */
    Symfony\Component\Serializer\Annotation\Groups;
use /** @noinspection PhpUnusedAliasInspection */
    Swagger\Annotations as SWG;

/**
 * 8. Возврат из аренды
 *
 * @ORM\Entity(repositoryClass="App\Repository\ReturnFromRentRepository")
 */
class ReturnFromRent implements DateListenerInterface, CreatedByListenerInterface, TaskItemInterface
{
    use ReturnFromRentTrait;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $createdBy;

    /**
     * @var Inspection
     * @ORM\OneToOne(targetEntity="App\Entity\Inspection", inversedBy="returnFromRent", cascade={"persist", "remove"})
     */
    private $inspection;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Equipment", inversedBy="returnFromRent", cascade={"persist", "remove"})
     */
    private $equipment;

    /**
     * Счетчик по наработке
     *
     * @ORM\OneToOne(targetEntity=OperatingTimeCounter::class, cascade={"persist", "remove"})
     */
    private $operatingTimeCounter;

    public function __construct()
    {
        $this->status = Marking::STATUS_CREATED;
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getInspection(): ?Inspection
    {
        return $this->inspection;
    }

    public function setInspection(?Inspection $inspection): self
    {
        $this->inspection = $inspection;

        return $this;
    }

    public function getEquipment(): ?Equipment
    {
        return $this->equipment;
    }

    public function setEquipment(Equipment $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOperatingTimeCounter()
    {
        return $this->operatingTimeCounter;
    }

    /**
     * @param mixed $operatingTimeCounter
     * @return $this
     */
    public function setOperatingTimeCounter($operatingTimeCounter)
    {
        $this->operatingTimeCounter = $operatingTimeCounter;
        return $this;
    }
}
