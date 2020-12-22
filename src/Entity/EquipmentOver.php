<?php

namespace App\Entity;

use App\Classes\Equipment\EquipmentOverTrait;
use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Classes\ApiParentController;

/**
 * Излишек/Не найденные записи (Комплектация в ремонт)
 *
 * Все поля текстовые только для отображения
 *
 * @SWG\Definition(
 *     definition="EquipmentOver",
 *     description="Излишек/Не найденные записи",
 * )
 * @ORM\Entity(repositoryClass="App\Repository\EquipmentOverRepository")
 */
class EquipmentOver
{
    use EquipmentOverTrait;

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
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     */
    private $pipeSerialNumber;

    /**
     * Серийный № ниппеля
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     */
    private $serialNoOfNipple;

    /**
     * Серийный № муфты
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     */
    private $couplingSerialNumber;

    /**
     * № Метки RFID
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     */
    private $rfidTagNo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EquipmentKit", inversedBy="over")
     */
    private $equipmentKit;

    /**
     * Комментарий
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     */
    private $comment;

    /**
     * Оборудование есть, проблема с меткой
     *
     * @ORM\Column(type="text", nullable=true)
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     */
    private $commentProblemWithMark;

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

    public function getEquipmentKit(): ?EquipmentKit
    {
        return $this->equipmentKit;
    }

    public function setEquipmentKit(?EquipmentKit $equipmentKit): self
    {
        $this->equipmentKit = $equipmentKit;

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

    /**
     * @return mixed
     */
    public function getCommentProblemWithMark()
    {
        return $this->commentProblemWithMark;
    }

    /**
     * @param mixed $commentProblemWithMark
     * @return $this
     */
    public function setCommentProblemWithMark($commentProblemWithMark)
    {
        $this->commentProblemWithMark = $commentProblemWithMark;
        return $this;
    }
}
