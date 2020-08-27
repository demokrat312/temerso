<?php

namespace App\Entity;

use App\Classes\Listener\Date\DateListenerInterface;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Счетчик по наработке
 *
 * @ORM\Entity(repositoryClass="App\Repository\OperatingTimeCounterRepository")
 */
class OperatingTimeCounter implements DateListenerInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Дата прихода из аренды (пользователь выбирает из встроенного календаря)
     *
     * @ORM\Column(type="datetime")
     */
    private $returnFromRentDate;

    /**
     * Дата начала работ (числовой ввод)
     *
     * @ORM\Column(type="string", length=255)
     */
    private $workStartDate;

    /**
     * № скважины (числовой ввод);
     *
     * @ORM\Column(type="string", length=255)
     */
    private $wellNumber;

    /**
     * Кол-во СПО (спуско-подъемных операций – это один из столбцов карточки оборудования);
     *
     * @ORM\Column(type="string", length=255)
     */
    private $spoAmount;

    /**
     * Проходка, м – ввод трех значений
     * Интервал от
     *
     * @ORM\Column(type="string", length=255)
     */
    private $penetrationFrom;

    /**
     * Проходка, м – ввод трех значений
     * Интервал до
     *
     * @ORM\Column(type="string", length=255)
     */
    private $penetrationTo;

    /**
     * Проходка, м – ввод трех значений
     * Итого
     *
     * @ORM\Column(type="string", length=255)
     */
    private $penetrationTotal;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReturnFromRentDate(): ?DateTimeInterface
    {
        return $this->returnFromRentDate;
    }

    public function setReturnFromRentDate(DateTimeInterface $returnFromRentDate): self
    {
        $this->returnFromRentDate = $returnFromRentDate;

        return $this;
    }

    public function getWorkStartDate(): ?string
    {
        return $this->workStartDate;
    }

    public function setWorkStartDate(string $workStartDate): self
    {
        $this->workStartDate = $workStartDate;

        return $this;
    }

    public function getWellNumber(): ?string
    {
        return $this->wellNumber;
    }

    public function setWellNumber(string $wellNumber): self
    {
        $this->wellNumber = $wellNumber;

        return $this;
    }

    public function getSpoAmount(): ?string
    {
        return $this->spoAmount;
    }

    public function setSpoAmount(string $spoAmount): self
    {
        $this->spoAmount = $spoAmount;

        return $this;
    }

    public function getPenetrationFrom(): ?string
    {
        return $this->penetrationFrom;
    }

    public function setPenetrationFrom(string $penetrationFrom): self
    {
        $this->penetrationFrom = $penetrationFrom;

        return $this;
    }

    public function getPenetrationTo(): ?string
    {
        return $this->penetrationTo;
    }

    public function setPenetrationTo(string $penetrationTo): self
    {
        $this->penetrationTo = $penetrationTo;

        return $this;
    }

    public function getPenetrationTotal(): ?string
    {
        return $this->penetrationTotal;
    }

    public function setPenetrationTotal(string $penetrationTotal): self
    {
        $this->penetrationTotal = $penetrationTotal;

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
}
