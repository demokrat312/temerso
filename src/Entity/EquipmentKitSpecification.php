<?php

namespace App\Entity;

use App\Entity\Reference\RefHardbandingNipple;
use App\Entity\Reference\RefInnerCoating;
use App\Entity\Reference\RefThreadCoating;
use App\Entity\Reference\RefTypeDisembarkation;
use App\Entity\Reference\RefTypeEquipment;
use App\Entity\Reference\RefTypeThread;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;

/**
 * Комлектация в аренду. Комплект. Характеристики
 *
 * @ORM\Entity(repositoryClass="App\Repository\EquipmentKitSpecificationRepository")
 */
class EquipmentKitSpecification
{
    /**
     * Ключ
     *
     * @ORM\Id()
     * @ORM\GeneratedValue
     * @var integer
     * @ORM\Column(type="integer")
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $id;

    /**
     * Тип оборудования
     *
     * @var RefTypeEquipment
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefTypeEquipment")
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $refTypeEquipment;

    /**
     * Тип высадки
     *
     * @var RefTypeDisembarkation
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefTypeDisembarkation")
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $refTypeDisembarkation;

    /**
     * Наружный диаметр трубы, (мм)
     *
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $outerDiameterOfThePipe;

    /**
     * Толщина стенки трубы, (мм)
     *
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $pipeWallThickness;

    /**
     * Тип резьбы
     *
     * @var RefTypeThread
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefTypeThread")
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $refTypeThread;

    /**
     * O.D. Замка ниппель  (мм)
     *
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $odlockNipple;

    /**
     * I.D. Замка ниппель  (мм)
     *
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $idlockNipple;

    /**
     * Длина трубы
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $pipeLength;

    /**
     * Угол заплетчика
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $shoulderAngle;

    /**
     * Длина под ключ ниппель, (мм)
     *
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $turnkeyLengthNipple;

    /**
     * Длина под ключ муфта, (мм)
     *
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $turnkeyLengthCoupling;

    /**
     * Покрытие резьбы
     *
     * @var RefThreadCoating
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefThreadCoating")
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $refThreadCoating;

    /**
     * Внутреннее покрытие
     *
     * @var RefInnerCoating
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefInnerCoating")
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $refInnerCoating;

    /**
     * Хардбендинг (муфта)
     *
     * @var RefHardbandingNipple
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefHardbandingNipple")
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $refHardbandingCoupling;

    /**
     * Комментарий: поле для ввода информации пользователем
     *
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
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
