<?php

namespace App\Entity;

use App\Classes\Listener\CreatedBy\CreatedByListenerInterface;
use App\Classes\Listener\Date\DateListenerInterface;
use App\Classes\ReturnFromRepair\ReturnFromRepairTrait;
use App\Classes\Task\TaskItemInterface;
use Doctrine\ORM\Mapping as ORM;
// не удалять, какой то баг со вложенным trait
use /** @noinspection PhpUnusedAliasInspection */
    Symfony\Component\Serializer\Annotation\Groups;
use /** @noinspection PhpUnusedAliasInspection */
    Swagger\Annotations as SWG;

/**
 * 8 ПРОЦЕСС. ВОЗВРАТ ОБОРУДОВАНИЯ ИЗ РЕМОНТА
 *
 * @ORM\Entity(repositoryClass="App\Repository\ReturnFromRepairRepository")
 */
class ReturnFromRepair implements DateListenerInterface, CreatedByListenerInterface, TaskItemInterface
{
    use ReturnFromRepairTrait;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Repair", inversedBy="returnFromRepair", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $repair;

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
     * @ORM\OneToOne(targetEntity="App\Entity\Inspection", inversedBy="returnFromRepair", cascade={"persist", "remove"})
     */
    private $inspection;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepair(): ?Repair
    {
        return $this->repair;
    }

    public function setRepair(Repair $repair): self
    {
        $this->repair = $repair;

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

    public function getInspection(): ?Inspection
    {
        return $this->inspection;
    }

    public function setInspection(?Inspection $inspection): self
    {
        $this->inspection = $inspection;

        return $this;
    }
}
