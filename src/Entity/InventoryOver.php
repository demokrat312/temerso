<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;

/**
 * Излишек(Инвентаризация)
 *
 * Все поля текстовые только для отображения
 *
 * @SWG\Definition(
 *     definition="InventoryOver",
 *     description="Излишек",
 * )
 * @ORM\Entity(repositoryClass="App\Repository\InventoryOverRepository")
 */
class InventoryOver
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Серийный № трубы
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pipeSerialNumber;

    /**
     * Серийный № ниппеля
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $serialNoOfNipple;

    /**
     * Серийный № муфты
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couplingSerialNumber;

    /**
     * № Метки RFID
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rfidTagNo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Inventory", inversedBy="over")
     */
    private $inventory;

    /**
     * Комментарий
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPipeSerialNumber(): ?string
    {
        return $this->pipeSerialNumber;
    }

    public function setPipeSerialNumber(?string $pipeSerialNumber): self
    {
        $this->pipeSerialNumber = $pipeSerialNumber;

        return $this;
    }

    public function getSerialNoOfNipple(): ?string
    {
        return $this->serialNoOfNipple;
    }

    public function setSerialNoOfNipple(?string $serialNoOfNipple): self
    {
        $this->serialNoOfNipple = $serialNoOfNipple;

        return $this;
    }

    public function getCouplingSerialNumber(): ?string
    {
        return $this->couplingSerialNumber;
    }

    public function setCouplingSerialNumber(?string $couplingSerialNumber): self
    {
        $this->couplingSerialNumber = $couplingSerialNumber;

        return $this;
    }

    public function getRfidTagNo(): ?string
    {
        return $this->rfidTagNo;
    }

    public function setRfidTagNo(?string $rfidTagNo): self
    {
        $this->rfidTagNo = $rfidTagNo;

        return $this;
    }

    public function getInventory(): ?Inventory
    {
        return $this->inventory;
    }

    public function setInventory(?Inventory $inventory): self
    {
        $this->inventory = $inventory;

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
}
