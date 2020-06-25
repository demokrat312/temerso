<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Дополнительные поля для карточки с привязкой к заданию
 *
 * @ORM\Entity(repositoryClass="App\Repository\TaskCardOtherFieldRepository")
 */
class TaskCardOtherField
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $taskTypeId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Card", inversedBy="taskCardOtherFields")
     * @ORM\JoinColumn(nullable=false)
     */
    private $card;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentProblemWithMark;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaskTypeId(): ?int
    {
        return $this->taskTypeId;
    }

    public function setTaskTypeId(int $taskTypeId): self
    {
        $this->taskTypeId = $taskTypeId;

        return $this;
    }

    public function getCard(): ?Card
    {
        return $this->card;
    }

    public function setCard(?Card $card): self
    {
        $this->card = $card;

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

    public function getCommentProblemWithMark(): ?string
    {
        return $this->commentProblemWithMark;
    }

    public function setCommentProblemWithMark(?string $commentProblemWithMark): self
    {
        $this->commentProblemWithMark = $commentProblemWithMark;

        return $this;
    }
}
