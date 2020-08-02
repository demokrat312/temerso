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
use App\Entity\Equipment;
use App\Entity\Inspection;
use App\Entity\Inventory;
use App\Entity\Marking;
use App\Entity\Repair;
use App\Entity\ReturnFromRent;
use App\Entity\ReturnFromRepair;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;

/**
 *
 * @see \App\Classes\Task\TaskExcelBuilder::build
 * @see \App\Classes\Task\TaskHelper::taskToArray
 */
class TaskItem
{
    const TYPE_MARKING = 1;
    const TYPE_INVENTORY = 2;
    const TYPE_INSPECTION = 3;
    const TYPE_EQUIPMENT = 4;
    const TYPE_RETURN_FROM_RENT = 5;
    const TYPE_REPAIR = 6;
    const TYPE_RETURN_FROM_REPAIR = 7;

    const TYPE_TITLE = [
        self::TYPE_MARKING => 'Маркировка',
        self::TYPE_INVENTORY => 'Инвентаризация',
        self::TYPE_INSPECTION => 'Инспекция',
        self::TYPE_EQUIPMENT => 'Комплектация в аренду',
        self::TYPE_RETURN_FROM_RENT => 'Возврат из аренды',
        self::TYPE_REPAIR => 'Комплектация в ремонт',
        self::TYPE_RETURN_FROM_REPAIR => 'Возврат из ремонта',
    ];

    const TYPE_CLASS = [
        self::TYPE_MARKING => Marking::class,
        self::TYPE_INVENTORY => Inventory::class,
        self::TYPE_INSPECTION => Inspection::class,
        self::TYPE_EQUIPMENT => Equipment::class,
        self::TYPE_RETURN_FROM_RENT => ReturnFromRent::class,
        self::TYPE_REPAIR => Repair::class,
        self::TYPE_RETURN_FROM_REPAIR => ReturnFromRepair::class,
    ];

    const TYPE_BY_CLASS = [
        Marking::class => self::TYPE_MARKING,
        Inventory::class => self::TYPE_INVENTORY,
        Inspection::class => self::TYPE_INSPECTION,
        Equipment::class => self::TYPE_EQUIPMENT,
        ReturnFromRent::class => self::TYPE_RETURN_FROM_RENT,
        Repair::class => self::TYPE_REPAIR,
        ReturnFromRepair::class => self::TYPE_RETURN_FROM_REPAIR,
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
    private $cardList;

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
    /**
     * @var string|null
     */
    private $comment;

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
    private function getCreatedBy(): User
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
    private function getExecutor(): ?User
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
    public function getCardList()
    {
        return $this->cardList;
    }

    /**
     * @param Card[]|Collection $cardList
     * @return $this
     */
    public function setCardList($cardList)
    {
        $newCards = [];
        foreach ($cardList as $card) {
            $newCards[] = $this->markingCardToTaskCardAdapter->getCard($card, self::TYPE_CLASS[$this->getTaskTypeId()], $this->getId());
        }
        $this->cardList = $newCards;

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

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     * @return $this
     */
    public function setComment(?string $comment)
    {
        $this->comment = $comment;
        return $this;
    }
}