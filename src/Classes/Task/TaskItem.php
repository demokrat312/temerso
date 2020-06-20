<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 19.06.2020
 * Time: 10:46
 */

namespace App\Classes\Task;


use App\Classes\Marking\MarkingCardToTaskCardAdapter;
use App\Entity\Card;
use App\Entity\Marking;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;

class TaskItem
{
    const TYPE_MARKING = 1;

    const TYPE_TITLE = [
        self::TYPE_MARKING => 'Маркировка',
    ];

    const TYPE_CLASS = [
        self::TYPE_MARKING => Marking::class
    ];

    /**
     * @var int
     */
    private $statusId;
    /**
     * @var User
     */
    private $createdBy;
    /**
     * @var User
     */
    private $executor;
    /**
     * @var Collection|Card[]
     */
    private $cards;

    /**
     * Entity id
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $taskTypeId;
    /**
     * @var MarkingCardToTaskCardAdapter
     */
    private $markingCardToTaskCardAdapter;

    public function __construct()
    {
        $this->markingCardToTaskCardAdapter = new MarkingCardToTaskCardAdapter();
    }


    /**
     * @return int
     */
    public function getStatusId(): int
    {
        return $this->statusId;
    }

    /**
     * @param int $statusId
     * @return $this
     */
    public function setStatusId(int $statusId)
    {
        $this->statusId = $statusId;
        return $this;
    }

    /**
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     * @return $this
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return User
     */
    public function getExecutor(): ?User
    {
        return $this->executor;
    }

    /**
     * @param User $executor
     * @return $this
     */
    public function setExecutor(?User $executor)
    {
        $this->executor = $executor;
        return $this;
    }

    /**
     * @return Card[]|Collection
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @param Card[]|Collection $cards
     * @return $this
     */
    public function setCards($cards)
    {
        $newCards = [];
        foreach ($cards as $card) {
            $newCards[] = $this->markingCardToTaskCardAdapter->getCard($card);
        }
        $this->cards = $newCards;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getTaskTypeId(): int
    {
        return $this->taskTypeId;
    }

    /**
     * @param int $taskTypeId
     * @return $this
     */
    public function setTaskTypeId(int $taskTypeId)
    {
        $this->taskTypeId = $taskTypeId;
        return $this;
    }

    public function getStatusTitle()
    {
        return Marking::STATUS_TITLE[$this->statusId];
    }

    public function getTaskTypeTitle()
    {
        return self::TYPE_TITLE[$this->taskTypeId];
    }

    public function getCreatedByFio()
    {
        return (string)$this->createdBy;
    }

    public function getExecutorFio()
    {
        return (string)$this->executor;
    }
}