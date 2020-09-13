<?php

namespace App\Entity;

use App\Classes\Card\CardShowHistoryInterface;
use App\Classes\Task\TaskCardOtherFieldTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Дополнительные поля для карточки с привязкой к заданию
 *
 * @ORM\Entity(repositoryClass="App\Repository\TaskCardOtherFieldRepository")
 */
class TaskCardOtherField implements CardShowHistoryInterface
{
    use TaskCardOtherFieldTrait;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Тип задачи
     *
     * @ORM\Column(type="integer")
     */
    private $taskTypeId;

    /**
     * Ключ задачи
     *
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $taskId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Card", inversedBy="taskCardOtherFields")
     * @ORM\JoinColumn(nullable=false)
     */
    private $card;

    /**
     * Примечание
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * Оборудование есть, проблема с меткой
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentProblemWithMark;

    public function __toString()
    {
        return '<td>test</td>';
    }

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

    /**
     * @return mixed
     */
    public function getTaskId()
    {
        return $this->taskId;
    }

    /**
     * @param mixed $taskId
     * @return $this
     */
    public function setTaskId($taskId)
    {
        $this->taskId = $taskId;
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
