<?php

namespace App\Entity;

use App\Entity\Reference\RefHardbandingNipple;
use App\Entity\Reference\RefInnerCoating;
use App\Entity\Reference\RefThreadCoating;
use App\Entity\Reference\RefTypeDisembarkation;
use App\Entity\Reference\RefTypeEquipment;
use App\Entity\Reference\RefTypeThread;
use Doctrine\ORM\Mapping as ORM;

/**
 * Комлектация в аренду. Комплект. Характеристики
 *
 * @ORM\Entity(repositoryClass="App\Repository\EquipmentKitSpecificationRepository")
 */
class EquipmentKitSpecification
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Тип оборудования
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefTypeEquipment")
     */
    private $refTypeEquipment;

    /**
     * Тип высадки
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefTypeDisembarkation")
     */
    private $refTypeDisembarkation;

    /**
     * Наружный диаметр трубы, (мм)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $outerDiameterOfThePipe;

    /**
     * Толщина стенки трубы, (мм)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $pipeWallThickness;

    /**
     * Тип резьбы
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefTypeThread")
     */
    private $refTypeThread;

    /**
     * O.D. Замка ниппель  (мм)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $odlockNipple;

    /**
     * I.D. Замка ниппель  (мм)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $idlockNipple;

    /**
     * Длина трубы
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pipeLength;

    /**
     * Угол заплетчика
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shoulderAngle;

    /**
     * Длина под ключ ниппель, (мм)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $turnkeyLengthNipple;

    /**
     * Длина под ключ муфта, (мм)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $turnkeyLengthCoupling;

    /**
     * Покрытие резьбы
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefThreadCoating")
     */
    private $refThreadCoating;

    /**
     * Внутреннее покрытие
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefInnerCoating")
     */
    private $refInnerCoating;

    /**
     * Хардбендинг (муфта)
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefHardbandingNipple")
     */
    private $refHardbandingCoupling;

    /**
     * Комментарий: поле для ввода информации пользователем
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\EquipmentKit", inversedBy="specification", cascade={"persist", "remove"})
     */
    private $equipmentKit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefTypeEquipment(): ?RefTypeEquipment
    {
        return $this->refTypeEquipment;
    }

    public function setRefTypeEquipment(?RefTypeEquipment $refTypeEquipment): self
    {
        $this->refTypeEquipment = $refTypeEquipment;

        return $this;
    }

    public function getRefTypeDisembarkation(): ?RefTypeDisembarkation
    {
        return $this->refTypeDisembarkation;
    }

    public function setRefTypeDisembarkation(?RefTypeDisembarkation $refTypeDisembarkation): self
    {
        $this->refTypeDisembarkation = $refTypeDisembarkation;

        return $this;
    }

    public function getOuterDiameterOfThePipe(): ?float
    {
        return $this->outerDiameterOfThePipe;
    }

    public function setOuterDiameterOfThePipe(?float $outerDiameterOfThePipe): self
    {
        $this->outerDiameterOfThePipe = $outerDiameterOfThePipe;

        return $this;
    }

    public function getPipeWallThickness(): ?float
    {
        return $this->pipeWallThickness;
    }

    public function setPipeWallThickness(?float $pipeWallThickness): self
    {
        $this->pipeWallThickness = $pipeWallThickness;

        return $this;
    }

    public function getRefTypeThread(): ?RefTypeThread
    {
        return $this->refTypeThread;
    }

    public function setRefTypeThread(?RefTypeThread $refTypeThread): self
    {
        $this->refTypeThread = $refTypeThread;

        return $this;
    }

    public function getOdlockNipple(): ?float
    {
        return $this->odlockNipple;
    }

    public function setOdlockNipple(?float $odlockNipple): self
    {
        $this->odlockNipple = $odlockNipple;

        return $this;
    }

    public function getIdlockNipple(): ?float
    {
        return $this->idlockNipple;
    }

    public function setIdlockNipple(?float $idlockNipple): self
    {
        $this->idlockNipple = $idlockNipple;

        return $this;
    }

    public function getPipeLength(): ?string
    {
        return $this->pipeLength;
    }

    public function setPipeLength(?string $pipeLength): self
    {
        $this->pipeLength = $pipeLength;

        return $this;
    }

    public function getShoulderAngle(): ?string
    {
        return $this->shoulderAngle;
    }

    public function setShoulderAngle(?string $shoulderAngle): self
    {
        $this->shoulderAngle = $shoulderAngle;

        return $this;
    }

    public function getTurnkeyLengthNipple(): ?float
    {
        return $this->turnkeyLengthNipple;
    }

    public function setTurnkeyLengthNipple(?float $turnkeyLengthNipple): self
    {
        $this->turnkeyLengthNipple = $turnkeyLengthNipple;

        return $this;
    }

    public function getTurnkeyLengthCoupling(): ?float
    {
        return $this->turnkeyLengthCoupling;
    }

    public function setTurnkeyLengthCoupling(?float $turnkeyLengthCoupling): self
    {
        $this->turnkeyLengthCoupling = $turnkeyLengthCoupling;

        return $this;
    }

    public function getRefThreadCoating(): ?RefThreadCoating
    {
        return $this->refThreadCoating;
    }

    public function setRefThreadCoating(?RefThreadCoating $refThreadCoating): self
    {
        $this->refThreadCoating = $refThreadCoating;

        return $this;
    }

    public function getRefInnerCoating(): ?RefInnerCoating
    {
        return $this->refInnerCoating;
    }

    public function setRefInnerCoating(?RefInnerCoating $refInnerCoating): self
    {
        $this->refInnerCoating = $refInnerCoating;

        return $this;
    }

    public function getRefHardbandingCoupling(): ?RefHardbandingNipple
    {
        return $this->refHardbandingCoupling;
    }

    public function setRefHardbandingCoupling(?RefHardbandingNipple $refHardbandingCoupling): self
    {
        $this->refHardbandingCoupling = $refHardbandingCoupling;

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

    public function getEquipmentKit(): ?EquipmentKit
    {
        return $this->equipmentKit;
    }

    public function setEquipmentKit(?EquipmentKit $equipmentKit): self
    {
        $this->equipmentKit = $equipmentKit;

        return $this;
    }
}
