<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 11.06.2020
 * Time: 08:32
 */

namespace App\Classes\Marking;


use App\Classes\Task\TaskItem;
use App\Entity\Card;
use App\Entity\Marking;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;

/**
 * Trait MarkingTrait
 * @package App\Classes\Marking
 *
 */
trait TaskEntityTrait
{
    /**
     * Статус задачи, название
     *
     * @var string
     * @api Поле нужно только для документации
     * @see TaskEntityTrait::getStatusTitle()
     */
    private $statusTitle;

    /**
     * Статус задачи, ключ
     *
     * @var string
     * @api Поле нужно только для документации
     * @see TaskEntityTrait::getStatusId()
     */
    private $statusId;

    /**
     * Кто создал. ФИО
     *
     * @var string
     * @api Поле нужно только для документации
     * @see TaskEntityTrait::getCreatedByFio()
     */
    private $createdByFio;

    /**
     * Исполнитель. ФИО
     *
     * @var string
     * @api Поле нужно только для документации
     * @see TaskEntityTrait::getExecutorFio()
     */
    private $executorFio;

    /**
     * Список карточек
     *
     * @var Card[]
     * @api Поле нужно только для документации
     * @see TaskEntityTrait::getCardList()
     */
    private $cardList;

    /**
     * Тип задачи (поле для списка)
     * @see \App\Admin\MarkingAdmin::configureListFields
     * @return string
     */
    public function getTaskType()
    {
        return TaskItem::TYPE_TITLE[TaskItem::TYPE_BY_CLASS[self::class]];
    }

    /**
     * Исполнитель
     * @see \App\Admin\MarkingAdmin::configureListFields
     */
    public function getExecutor(): ?User
    {
        /** @var User $user */
        return $this->getUsers()->first() ?: null;
    }


    /**
     * @see TaskEntityTrait::statusId
     *
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     * @SWG\Property(description="Статус задачи, ключ")
     */
    public function getStatusId(): int
    {
        return $this->getStatus();
    }

    /**
     * @see TaskEntityTrait::statusTitle
     *
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     *
     * @see templates/marking/show.html.twig
     * @return mixed
     */
    public function getStatusTitle(): string
    {
        return Marking::STATUS_TITLE[$this->status];
    }

    /**
     * @see TaskEntityTrait::$createdByFio
     *
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     *
     * @return string
     */
    public function getCreatedByFio(): string
    {
        return $this->createdBy ? (string)$this->createdBy->getFio() : 'error';
    }

    /**
     * @see TaskEntityTrait::$executorFio
     *
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     *
     * @return string
     */
    public function getExecutorFio(): string
    {
        return (string)$this->getExecutor();
    }

    /**
     * @see TaskEntityTrait::$cardList
     *
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     *
     * @return string
     */
    public function getCardList(): Collection
    {
        $className = self::class;
        $this->getCards()->map(function(Card $card) use ($className) {
            $card->setTaskClassName($className);
        });
        return $this->getCards();
    }

    public function __toString()
    {
        return $this->createdBy ? (string)$this->createdBy->getFio() : 'error';
    }
}