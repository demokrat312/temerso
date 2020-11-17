<?php

namespace App\Entity;

use App\Application\Sonata\MediaBundle\Entity\Media;
use App\Classes\Card\CardTemporaryTrait;
use App\Classes\Card\CardTrait;
use App\Classes\Card\CardStatusHelper;
use App\Classes\Listener\CreatedBy\CreatedByListenerInterface;
use App\Classes\Listener\Date\DateListenerInterface;
use App\Entity\Reference\RefHardbandingNipple;
use App\Entity\Reference\RefHardbandingNippleState;
use App\Entity\Reference\RefInnerCoating;
use App\Entity\Reference\RefIpcWedgeZoneLandingZone;
use App\Entity\Reference\RefLabelResurfacing;
use App\Entity\Reference\RefLockClassNipple;
use App\Entity\Reference\RefNippleThread;
use App\Entity\Reference\RefNippleThreadCondition;
use App\Entity\Reference\RefPipeBodyClass;
use App\Entity\Reference\RefPipeStrengthGroup;
use App\Entity\Reference\RefStatePersistent;
use App\Entity\Reference\RefThreadCoating;
use App\Entity\Reference\RefTypeDisembarkation;
use App\Entity\Reference\RefTypeEquipment;
use App\Entity\Reference\RefTypeThread;
use App\Entity\Reference\RefVisualControl;
use App\Entity\Reference\RefWarehouse;
use App\Entity\Reference\RefWearClass;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Classes\Card\CardIdentificationResponse;
use App\Classes\ApiParentController;

/**
 * Временная запись карточки
 * До статуса Выполнено полностью (Принять от Исполнителя).
 * Пока только для испекции
 *
 * @ORM\Entity(repositoryClass="App\Repository\CardTemporaryRepository")
 *
 * @see \App\Classes\Card\CardStatusHelper
 */
class CardTemporary
{
    use CardTemporaryTrait;

    /**
     * Ключ
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Тип задачи
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    private $taskTypeId;

    /**
     * Ключ задачи
     *
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $taskId;

    /**
     * Ключ карточки
     *
     * @var Card
     * @ORM\ManyToOne(targetEntity="App\Entity\Card", cascade={"persist"})
     */
    private $card;

    /**
     * Тип оборудования
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefTypeEquipment")
     */
    private $ref_type_equipment;

    /**
     * № Метки RFID
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $rfidTagNo;

    /**
     * Серийный № трубы
     *
     * @ORM\Column(type="string", nullable=true)
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $pipeSerialNumber;

    /**
     * Серийный № ниппеля
     *
     * @ORM\Column(type="string", nullable=true)
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $serialNoOfNipple;

    /**
     * Серийный № муфты
     *
     * @ORM\Column(type="string", nullable=true)
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $couplingSerialNumber;

    /**
     * Наружный диаметр трубы, (мм)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $outer_diameter_of_the_pipe;

    /**
     * Толщина стенки трубы, (мм)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $pipe_wall_thickness;

    /**
     * Тип высадки
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefTypeDisembarkation")
     */
    private $ref_type_disembarkation;

    /**
     * Тип резьбы
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefTypeThread")
     */
    private $ref_type_thread;

    /**
     * O.D. Замка ниппель  (мм)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $odlock_nipple;

    /**
     * Диаметр носика ниппеля
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $nipple_nose_diameter;

    /**
     * O.D. Замка муфта  (мм)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $odlock_coupling;

    /**
     * LBC Длина резьбы муфта (мм)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $lbc_thread_length_coupler;

    /**
     * QC Диаметр расточки муфта(мм)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $qc_bore_diameter_coupling;

    /**
     * I.D. Замка ниппель  (мм)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $idlock_nipple;

    /**
     * Длина трубы (м)
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pipe_length;

    /**
     * Вес трубы (кг)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $weight_of_pipe;

    /**
     * Угол заплечика (градус)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $shoulder_angle;

    /**
     * Длина под ключ ниппель, (мм)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $turnkey_length_nipple;

    /**
     * Длина под ключ муфта, (мм)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $turnkey_length_coupling;

    /**
     * Покрытие резьбы
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefThreadCoating")
     */
    private $ref_thread_coating;

    /**
     * Внутреннее покрытие
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefInnerCoating")
     */
    private $ref_inner_coating;

    /**
     * Хардбендинг (ниппель)
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefHardbandingNipple")
     */
    private $ref_hardbanding_nipple;

    /**
     * Хардбендинг (муфта)
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefHardbandingNipple")
     */
    private $ref_hardbanding_coupling;

    /**
     * Класс износа
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefWearClass")
     */
    private $ref_wear_class;

    /**
     * Визуальный контроль состояния внутреннего покрытия
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefVisualControl")
     */
    private $ref_visual_control;

    /**
     * Глубина наминов в зоне работы клиньев max (мм)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $depth_of_naminov;

    /**
     * Изгиб ниппельного конца max (мм)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $nipple_end_bend_max;

    /**
     * Изгиб муфтового конца max (мм)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $coupling_end_bend_max;

    /**
     * Общий изгиб тела трубы max (мм)
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $the_total_bend_of_the_pipe_body_max;

    /**
     * МПК зоны клинев и зоны высадки
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefIpcWedgeZoneLandingZone")
     */
    private $ref_ipc_wedge_zone_and_landing_zone;

    /**
     * УЗК зоны клиньев и зоны высадки
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefIpcWedgeZoneLandingZone")
     */
    private $ref_ultrasonic_testing;

    /**
     * EMI тела трубы (багги)
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefIpcWedgeZoneLandingZone")
     */
    private $ref_emi_body_pipes;

    /**
     * Класс тела трубы
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefPipeBodyClass")
     */
    private $ref_pipe_body_class;

    /**
     * Контроль шага резьбы ниппеля плоским шаблоном
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefNippleThread")
     */
    private $ref_nipple_thread;

    /**
     * Состояние резьбы ниппеля
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefNippleThreadCondition")
     */
    private $ref_nipple_thread_condition;

    /**
     * Состояние упорных торцев ниппеля
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefStatePersistent")
     */
    private $ref_state_persistent;

    /**
     * МПК резьбы ниппеля
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefIpcWedgeZoneLandingZone")
     */
    private $ref_ipc_thread_nipple;

    /**
     * Хардбендинг ниппель (состояние)
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefHardbandingNippleState")
     */
    private $ref_hardbending_nipple_state;

    /**
     * Хардбендинг ниппель (диаметр) мм
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $hardbanding_nipplemm_diameter;

    /**
     * Хардбендинг ниппель (высота наплавки) мм
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $hardbanding_nipple_height;

    /**
     * Класс замка ниппель
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefLockClassNipple")
     */
    private $ref_lock_class_nipple;

    /**
     * Состояние резьбы муфты
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefNippleThreadCondition")
     */
    private $ref_coupling_thread_condition;

    /**
     * Состояние упорных торцев муфты
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefStatePersistent")
     */
    private $ref_status_coupling_end_faces;

    /**
     * МПК резьбы муфты
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefIpcWedgeZoneLandingZone")
     */
    private $ref_ipc_thread_coupling;

    /**
     * УЗК резьбы муфты
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefIpcWedgeZoneLandingZone")
     */
    private $ref_uzk_thread_coupling;

    /**
     * Хардбендинг муфта (состояние)
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefHardbandingNippleState")
     */
    private $ref_hardbendig_coupling_state;

    /**
     * Хардбендинг муфта (диаметр) мм
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $hardbanding_coupler_diameter;

    /**
     * Хардбендинг муфта (высота наплавки) мм
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $hardbanding_coupling_height_mm;

    /**
     * Класс замка муфта
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefLockClassNipple")
     */
    private $lock_class_coupling;

    /**
     * @ORM\ManyToMany(targetEntity="App\Application\Sonata\MediaBundle\Entity\Media",cascade={"persist"})
     * @ORM\JoinTable(
     *     name="card_temporary_image_media",
     *     joinColumns={
     *          @ORM\JoinColumn(name="card_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     *     }
     * )
     */
    private $images;

    /**
     * Учет/Инвентаризация. По умолчанию у создаваемых карточек будет проставляться 1.
     *
     * @ORM\Column(type="boolean", options={"default" : 1})
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $accounting;


    /** Дополнительные поля */

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

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->accounting = true; // По умолчанию, есть на складе
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRefTypeEquipment(): ?RefTypeEquipment
    {
        return $this->ref_type_equipment;
    }

    public function setRefTypeEquipment(?RefTypeEquipment $ref_type_equipment): self
    {
        $this->ref_type_equipment = $ref_type_equipment;

        return $this;
    }

    /**
     * @return int
     */
    public function getTaskTypeId()
    {
        return $this->taskTypeId;
    }

    /**
     * @param int $taskTypeId
     * @return $this
     */
    public function setTaskTypeId($taskTypeId)
    {
        $this->taskTypeId = $taskTypeId;
        return $this;
    }

    /**
     * @return int
     */
    public function getTaskId()
    {
        return $this->taskId;
    }

    /**
     * @param int $taskId
     * @return $this
     */
    public function setTaskId($taskId)
    {
        $this->taskId = $taskId;
        return $this;
    }

    /**
     * @return Card
     */
    public function getCard(): ?Card
    {
        return $this->card;
    }

    /**
     * @param Card $card
     * @return $this
     */
    public function setCard(?Card $card)
    {
        $this->card = $card;
        return $this;
    }

    public function getRfidTagNo() : string
    {
        return (string)$this->rfidTagNo;
    }

    public function setRfidTagNo($rfidTagNo): self
    {
        $this->rfidTagNo = $rfidTagNo;

        return $this;
    }

    public function getPipeSerialNumber()
    {
        return $this->pipeSerialNumber;
    }

    public function setPipeSerialNumber($pipeSerialNumber): self
    {
        $this->pipeSerialNumber = $pipeSerialNumber;

        return $this;
    }

    public function getSerialNoOfNipple()
    {
        return $this->serialNoOfNipple;
    }

    public function setSerialNoOfNipple($serialNoOfNipple): self
    {
        $this->serialNoOfNipple = $serialNoOfNipple;

        return $this;
    }

    public function getCouplingSerialNumber()
    {
        return $this->couplingSerialNumber;
    }

    public function setCouplingSerialNumber($couplingSerialNumber): self
    {
        $this->couplingSerialNumber = $couplingSerialNumber;

        return $this;
    }

    public function getOuterDiameterOfThePipe()
    {
        return $this->outer_diameter_of_the_pipe;
    }

    public function setOuterDiameterOfThePipe($outer_diameter_of_the_pipe): self
    {
        $this->outer_diameter_of_the_pipe = $outer_diameter_of_the_pipe;

        return $this;
    }

    public function getPipeWallThickness()
    {
        return $this->pipe_wall_thickness;
    }

    public function setPipeWallThickness($pipe_wall_thickness): self
    {
        $this->pipe_wall_thickness = $pipe_wall_thickness;

        return $this;
    }

    public function getRefTypeDisembarkation(): ?RefTypeDisembarkation
    {
        return $this->ref_type_disembarkation;
    }

    public function setRefTypeDisembarkation(?RefTypeDisembarkation $ref_type_disembarkation): self
    {
        $this->ref_type_disembarkation = $ref_type_disembarkation;

        return $this;
    }

    public function getRefTypeThread(): ?RefTypeThread
    {
        return $this->ref_type_thread;
    }

    public function setRefTypeThread(?RefTypeThread $ref_type_thread): self
    {
        $this->ref_type_thread = $ref_type_thread;

        return $this;
    }

    public function getOdlockNipple()
    {
        return $this->odlock_nipple;
    }

    public function setOdlockNipple($odlock_nipple): self
    {
        $this->odlock_nipple = $odlock_nipple;

        return $this;
    }

    public function getNippleNoseDiameter()
    {
        return $this->nipple_nose_diameter;
    }

    public function setNippleNoseDiameter($nipple_nose_diameter): self
    {
        $this->nipple_nose_diameter = $nipple_nose_diameter;

        return $this;
    }

    public function getOdlockCoupling()
    {
        return $this->odlock_coupling;
    }

    public function setOdlockCoupling($odlock_coupling): self
    {
        $this->odlock_coupling = $odlock_coupling;

        return $this;
    }

    public function getLbcThreadLengthCoupler()
    {
        return $this->lbc_thread_length_coupler;
    }

    public function setLbcThreadLengthCoupler($lbc_thread_length_coupler): self
    {
        $this->lbc_thread_length_coupler = $lbc_thread_length_coupler;

        return $this;
    }

    public function getQcBoreDiameterCoupling()
    {
        return $this->qc_bore_diameter_coupling;
    }

    public function setQcBoreDiameterCoupling($qc_bore_diameter_coupling): self
    {
        $this->qc_bore_diameter_coupling = $qc_bore_diameter_coupling;

        return $this;
    }

    public function getIdlockNipple()
    {
        return $this->idlock_nipple;
    }

    public function setIdlockNipple($idlock_nipple): self
    {
        $this->idlock_nipple = $idlock_nipple;

        return $this;
    }

    public function getPipeLength()
    {
        return $this->pipe_length;
    }

    public function setPipeLength($pipe_length): self
    {
        $this->pipe_length = $pipe_length;

        return $this;
    }

    public function getWeightOfPipe()
    {
        return $this->weight_of_pipe;
    }

    public function setWeightOfPipe($weight_of_pipe): self
    {
        $this->weight_of_pipe = $weight_of_pipe;

        return $this;
    }

    public function getShoulderAngle()
    {
        return $this->shoulder_angle;
    }

    public function setShoulderAngle($shoulder_angle): self
    {
        $this->shoulder_angle = $shoulder_angle;

        return $this;
    }

    public function getTurnkeyLengthNipple()
    {
        return $this->turnkey_length_nipple;
    }

    public function setTurnkeyLengthNipple($turnkey_length_nipple): self
    {
        $this->turnkey_length_nipple = $turnkey_length_nipple;

        return $this;
    }

    public function getTurnkeyLengthCoupling()
    {
        return $this->turnkey_length_coupling;
    }

    public function setTurnkeyLengthCoupling($turnkey_length_coupling): self
    {
        $this->turnkey_length_coupling = $turnkey_length_coupling;

        return $this;
    }

    public function getRefThreadCoating(): ?RefThreadCoating
    {
        return $this->ref_thread_coating;
    }

    public function setRefThreadCoating(?RefThreadCoating $ref_thread_coating): self
    {
        $this->ref_thread_coating = $ref_thread_coating;

        return $this;
    }

    public function getRefInnerCoating(): ?RefInnerCoating
    {
        return $this->ref_inner_coating;
    }

    public function setRefInnerCoating(?RefInnerCoating $ref_inner_coating): self
    {
        $this->ref_inner_coating = $ref_inner_coating;

        return $this;
    }

    public function getRefHardbandingNipple(): ?RefHardbandingNipple
    {
        return $this->ref_hardbanding_nipple;
    }

    public function setRefHardbandingNipple(?RefHardbandingNipple $ref_hardbanding_nipple): self
    {
        $this->ref_hardbanding_nipple = $ref_hardbanding_nipple;

        return $this;
    }

    public function getRefHardbandingCoupling(): ?RefHardbandingNipple
    {
        return $this->ref_hardbanding_coupling;
    }

    public function setRefHardbandingCoupling(?RefHardbandingNipple $ref_hardbanding_coupling): self
    {
        $this->ref_hardbanding_coupling = $ref_hardbanding_coupling;

        return $this;
    }

    public function getRefWearClass(): ?RefWearClass
    {
        return $this->ref_wear_class;
    }

    public function setRefWearClass(?RefWearClass $ref_wear_class): self
    {
        $this->ref_wear_class = $ref_wear_class;

        return $this;
    }

    public function getRefVisualControl(): ?RefVisualControl
    {
        return $this->ref_visual_control;
    }

    public function setRefVisualControl(?RefVisualControl $ref_visual_control): self
    {
        $this->ref_visual_control = $ref_visual_control;

        return $this;
    }

    public function getDepthOfNaminov()
    {
        return $this->depth_of_naminov;
    }

    public function setDepthOfNaminov($depth_of_naminov): self
    {
        $this->depth_of_naminov = $depth_of_naminov;

        return $this;
    }

    public function getNippleEndBendMax()
    {
        return $this->nipple_end_bend_max;
    }

    public function setNippleEndBendMax($nipple_end_bend_max): self
    {
        $this->nipple_end_bend_max = $nipple_end_bend_max;

        return $this;
    }

    public function getCouplingEndBendMax()
    {
        return $this->coupling_end_bend_max;
    }

    public function setCouplingEndBendMax($coupling_end_bend_max): self
    {
        $this->coupling_end_bend_max = $coupling_end_bend_max;

        return $this;
    }

    public function getTheTotalBendOfThePipeBodyMax()
    {
        return $this->the_total_bend_of_the_pipe_body_max;
    }

    public function setTheTotalBendOfThePipeBodyMax($the_total_bend_of_the_pipe_body_max): self
    {
        $this->the_total_bend_of_the_pipe_body_max = $the_total_bend_of_the_pipe_body_max;

        return $this;
    }

    public function getRefIpcWedgeZoneAndLandingZone(): ?RefIpcWedgeZoneLandingZone
    {
        return $this->ref_ipc_wedge_zone_and_landing_zone;
    }

    public function setRefIpcWedgeZoneAndLandingZone(?RefIpcWedgeZoneLandingZone $ref_ipc_wedge_zone_and_landing_zone): self
    {
        $this->ref_ipc_wedge_zone_and_landing_zone = $ref_ipc_wedge_zone_and_landing_zone;

        return $this;
    }

    public function getRefUltrasonicTesting(): ?RefIpcWedgeZoneLandingZone
    {
        return $this->ref_ultrasonic_testing;
    }

    public function setRefUltrasonicTesting(?RefIpcWedgeZoneLandingZone $ref_ultrasonic_testing): self
    {
        $this->ref_ultrasonic_testing = $ref_ultrasonic_testing;

        return $this;
    }

    public function getRefEmiBodyPipes(): ?RefIpcWedgeZoneLandingZone
    {
        return $this->ref_emi_body_pipes;
    }

    public function setRefEmiBodyPipes(?RefIpcWedgeZoneLandingZone $ref_emi_body_pipes): self
    {
        $this->ref_emi_body_pipes = $ref_emi_body_pipes;

        return $this;
    }

    public function getRefPipeBodyClass(): ?RefPipeBodyClass
    {
        return $this->ref_pipe_body_class;
    }

    public function setRefPipeBodyClass(?RefPipeBodyClass $ref_pipe_body_class): self
    {
        $this->ref_pipe_body_class = $ref_pipe_body_class;

        return $this;
    }

    public function getRefNippleThread(): ?RefNippleThread
    {
        return $this->ref_nipple_thread;
    }

    public function setRefNippleThread(?RefNippleThread $ref_nipple_thread): self
    {
        $this->ref_nipple_thread = $ref_nipple_thread;

        return $this;
    }

    public function getRefNippleThreadCondition(): ?RefNippleThreadCondition
    {
        return $this->ref_nipple_thread_condition;
    }

    public function setRefNippleThreadCondition(?RefNippleThreadCondition $ref_nipple_thread_condition): self
    {
        $this->ref_nipple_thread_condition = $ref_nipple_thread_condition;

        return $this;
    }

    public function getRefStatePersistent(): ?RefStatePersistent
    {
        return $this->ref_state_persistent;
    }

    public function setRefStatePersistent(?RefStatePersistent $ref_state_persistent): self
    {
        $this->ref_state_persistent = $ref_state_persistent;

        return $this;
    }

    public function getRefIpcThreadNipple(): ?RefIpcWedgeZoneLandingZone
    {
        return $this->ref_ipc_thread_nipple;
    }

    public function setRefIpcThreadNipple(?RefIpcWedgeZoneLandingZone $ref_ipc_thread_nipple): self
    {
        $this->ref_ipc_thread_nipple = $ref_ipc_thread_nipple;

        return $this;
    }

    public function getRefHardbendingNippleState(): ?RefHardbandingNippleState
    {
        return $this->ref_hardbending_nipple_state;
    }

    public function setRefHardbendingNippleState(?RefHardbandingNippleState $ref_hardbending_nipple_state): self
    {
        $this->ref_hardbending_nipple_state = $ref_hardbending_nipple_state;

        return $this;
    }

    public function getHardbandingNipplemmDiameter()
    {
        return $this->hardbanding_nipplemm_diameter;
    }

    public function setHardbandingNipplemmDiameter($hardbanding_nipplemm_diameter): self
    {
        $this->hardbanding_nipplemm_diameter = $hardbanding_nipplemm_diameter;

        return $this;
    }

    public function getHardbandingNippleHeight()
    {
        return $this->hardbanding_nipple_height;
    }

    public function setHardbandingNippleHeight($hardbanding_nipple_height): self
    {
        $this->hardbanding_nipple_height = $hardbanding_nipple_height;

        return $this;
    }

    public function getRefLockClassNipple(): ?RefLockClassNipple
    {
        return $this->ref_lock_class_nipple;
    }

    public function setRefLockClassNipple(?RefLockClassNipple $ref_lock_class_nipple): self
    {
        $this->ref_lock_class_nipple = $ref_lock_class_nipple;

        return $this;
    }

    public function getRefCouplingThreadCondition(): ?RefNippleThreadCondition
    {
        return $this->ref_coupling_thread_condition;
    }

    public function setRefCouplingThreadCondition(?RefNippleThreadCondition $ref_coupling_thread_condition): self
    {
        $this->ref_coupling_thread_condition = $ref_coupling_thread_condition;

        return $this;
    }

    public function getRefStatusCouplingEndFaces(): ?RefStatePersistent
    {
        return $this->ref_status_coupling_end_faces;
    }

    public function setRefStatusCouplingEndFaces(?RefStatePersistent $ref_status_coupling_end_faces): self
    {
        $this->ref_status_coupling_end_faces = $ref_status_coupling_end_faces;

        return $this;
    }

    public function getRefIpcThreadCoupling(): ?RefIpcWedgeZoneLandingZone
    {
        return $this->ref_ipc_thread_coupling;
    }

    public function setRefIpcThreadCoupling(?RefIpcWedgeZoneLandingZone $ref_ipc_thread_coupling): self
    {
        $this->ref_ipc_thread_coupling = $ref_ipc_thread_coupling;

        return $this;
    }

    public function getRefUzkThreadCoupling(): ?RefIpcWedgeZoneLandingZone
    {
        return $this->ref_uzk_thread_coupling;
    }

    public function setRefUzkThreadCoupling(?RefIpcWedgeZoneLandingZone $ref_uzk_thread_coupling): self
    {
        $this->ref_uzk_thread_coupling = $ref_uzk_thread_coupling;

        return $this;
    }

    public function getRefHardbendigCouplingState(): ?RefHardbandingNippleState
    {
        return $this->ref_hardbendig_coupling_state;
    }

    public function setRefHardbendigCouplingState(?RefHardbandingNippleState $ref_hardbendig_coupling_state): self
    {
        $this->ref_hardbendig_coupling_state = $ref_hardbendig_coupling_state;

        return $this;
    }

    public function getHardbandingCouplerDiameter()
    {
        return $this->hardbanding_coupler_diameter;
    }

    public function setHardbandingCouplerDiameter($hardbanding_coupler_diameter): self
    {
        $this->hardbanding_coupler_diameter = $hardbanding_coupler_diameter;

        return $this;
    }

    public function getHardbandingCouplingHeightMm()
    {
        return $this->hardbanding_coupling_height_mm;
    }

    public function setHardbandingCouplingHeightMm($hardbanding_coupling_height_mm): self
    {
        $this->hardbanding_coupling_height_mm = $hardbanding_coupling_height_mm;

        return $this;
    }

    public function getLockClassCoupling(): ?RefLockClassNipple
    {
        return $this->lock_class_coupling;
    }

    public function setLockClassCoupling(?RefLockClassNipple $lock_class_coupling): self
    {
        $this->lock_class_coupling = $lock_class_coupling;

        return $this;
    }

    /**
     * @param string|null $context
     * @return Collection|Media[]
     */
    public function getImages(string $context = null): Collection
    {
        if($context) {
            $criteria = Criteria::create()->where(Criteria::expr()->eq("context", $context));
            return $this->images->matching($criteria);
        }

        //<editor-fold desc="Не выводим повторяющиеся фотографии">
        $hasImages = [];
        $image = new ArrayCollection();

        foreach ($this->images as $image) {
            if(in_array($image->getName(), $hasImages))continue;

            $image->add($image);
            $hasImages[] = $image->getName();
        }
        //</editor-fold>
        return $image;
    }

    public function addImage($image): self
    {
        if ($image && !$this->images->contains($image)) {
            $this->images[] = $image;
        }

        return $this;
    }

    public function removeImage(Media $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
        }

        return $this;
    }

    public function getAccounting(): ?bool
    {
        return $this->accounting;
    }

    public function setAccounting(bool $accounting): self
    {
        $this->accounting = $accounting;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     * @return $this
     */
    public function setComment($comment)
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
