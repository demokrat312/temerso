<?php

namespace App\Entity;

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
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CardRepository")
 */
class Card
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
    private $ref_type_equipment;

    /**
     * Статус
     *
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * Местоположение
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * Наработка моточасов
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $operating_hours;

    /**
     * № Склада
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefWarehouse")
     */
    private $ref_warehouse;

    /**
     * Серийный № метки RFID
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rfid_tag_serial_no;

    /**
     * № Метки RFID
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rfid_tag_no;

    /**
     * Серийный № трубы
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pipe_serial_number;

    /**
     * Серийный № ниппеля
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $serial_no_of_nipple;

    /**
     * Серийный № муфты
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $coupling_serial_number;

    /**
     * Серийный № после ремонта
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $serial_no_after_repair;

    /**
     * Наружный диаметр трубы, (мм)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $outer_diameter_of_the_pipe;

    /**
     * Толщина стенки трубы, (мм)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pipe_wall_thickness;

    /**
     * Тип высадки
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefTypeDisembarkation")
     */
    private $ref_type_disembarkation;

    /**
     * Группа прочности трубы
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefPipeStrengthGroup")
     */
    private $ref_pipe_strength_group;

    /**
     * Тип резьбы
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefTypeThread")
     */
    private $ref_type_thread;

    /**
     * O.D. Замка ниппель  (мм)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $odlock_nipple;

    /**
     * D.F.  Фаска ниппель (мм)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dfchamfer_nipple;

    /**
     * LPC   Длина резьбы ниппель (мм)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $lpc_thread_length_nipple;

    /**
     * Диаметр носика ниппеля
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nipple_nose_diameter;

    /**
     * O.D. Замка муфта  (мм)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $odlock_coupling;

    /**
     * D.F.  Фаска муфта (мм)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dfchamfer_coupling;

    /**
     * LBC Длина резьбы муфта (мм)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $lbc_thread_length_coupler;

    /**
     * QC Диаметр расточки муфта(мм)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $qc_bore_diameter_coupling;

    /**
     * I.D. Замка ниппель  (мм)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idlock_nipple;

    /**
     * Длина трубы (м)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pipe_length;

    /**
     * Вес трубы (кг)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $weight_of_pipe;

    /**
     * Угол заплечика (градус)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $shoulder_angle;

    /**
     * Длина под ключ ниппель, (мм)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $turnkey_length_nipple;

    /**
     * Длина под ключ муфта, (мм)
     *
     * @ORM\Column(type="integer", nullable=true)
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
     * Номер Сертификата на комплект БТ
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $bt_certificate_number;

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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $depth_of_naminov;

    /**
     * Изгиб ниппельного конца max (мм)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nipple_end_bend_max;

    /**
     * Изгиб муфтового конца max (мм)
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $coupling_end_bend_max;

    /**
     * Общий изгиб тела трубы max (мм)
     *
     * @ORM\Column(type="integer", nullable=true)
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hardbanding_nipplemm_diameter;

    /**
     * Хардбендинг ниппель (высота наплавки) мм
     *
     * @ORM\Column(type="integer", nullable=true)
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hardbanding_coupler_diameter;

    /**
     * Хардбендинг муфта (высота наплавки) мм
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hardbanding_coupling_height_mm;

    /**
     * Класс замка муфта
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $lock_class_coupling;

    /**
     * Миним. ширина упорного уступа ниппеля при эксцентрич износе мм
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $min_the_width_thrust_shoulder;

    /**
     * Миним. ширина упорного уступа муфты при эксцентрич износе мм
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $min_width_stop_shoulder;

    /**
     * Миним. Длина переходного участка высадки miu,  мм
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $min_length_transition_section;

    /**
     * Метка для перешлифовки
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefLabelResurfacing")
     */
    private $ref_label_resurfacing;

    /**
     * Минимальный момент свинчивания замка, кНм
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $the_minimum_moment;

    /**
     * Максимальный момент свинчивания замка, кНм
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $the_maximum_moment;

    /**
     * Предельный  момент кручения  замка, кНм
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $the_limiting_moment;

    /**
     * Предельная растягивающая нагрузка замка, Кн
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $the_ultimate_tensile;

    /**
     * Предельный  момент кручения  трубы, кНм
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $the_ultimate_torque_of_the_tube;

    /**
     * Предельная растягивающая нагрузка трубы, Кн
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $the_ultimate_tensile_load_of_the_pipe;

    public function getId(): ?int
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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getOperatingHours(): ?int
    {
        return $this->operating_hours;
    }

    public function setOperatingHours(?int $operating_hours): self
    {
        $this->operating_hours = $operating_hours;

        return $this;
    }

    public function getRefWarehouse(): ?RefWarehouse
    {
        return $this->ref_warehouse;
    }

    public function setRefWarehouse(?RefWarehouse $ref_warehouse): self
    {
        $this->ref_warehouse = $ref_warehouse;

        return $this;
    }

    public function getRfidTagSerialNo(): ?int
    {
        return $this->rfid_tag_serial_no;
    }

    public function setRfidTagSerialNo(?int $rfid_tag_serial_no): self
    {
        $this->rfid_tag_serial_no = $rfid_tag_serial_no;

        return $this;
    }

    public function getRfidTagNo(): ?int
    {
        return $this->rfid_tag_no;
    }

    public function setRfidTagNo(?int $rfid_tag_no): self
    {
        $this->rfid_tag_no = $rfid_tag_no;

        return $this;
    }

    public function getPipeSerialNumber(): ?int
    {
        return $this->pipe_serial_number;
    }

    public function setPipeSerialNumber(?int $pipe_serial_number): self
    {
        $this->pipe_serial_number = $pipe_serial_number;

        return $this;
    }

    public function getSerialNoOfNipple(): ?int
    {
        return $this->serial_no_of_nipple;
    }

    public function setSerialNoOfNipple(?int $serial_no_of_nipple): self
    {
        $this->serial_no_of_nipple = $serial_no_of_nipple;

        return $this;
    }

    public function getCouplingSerialNumber(): ?int
    {
        return $this->coupling_serial_number;
    }

    public function setCouplingSerialNumber(?int $coupling_serial_number): self
    {
        $this->coupling_serial_number = $coupling_serial_number;

        return $this;
    }

    public function getSerialNoAfterRepair(): ?int
    {
        return $this->serial_no_after_repair;
    }

    public function setSerialNoAfterRepair(?int $serial_no_after_repair): self
    {
        $this->serial_no_after_repair = $serial_no_after_repair;

        return $this;
    }

    public function getOuterDiameterOfThePipe(): ?int
    {
        return $this->outer_diameter_of_the_pipe;
    }

    public function setOuterDiameterOfThePipe(?int $outer_diameter_of_the_pipe): self
    {
        $this->outer_diameter_of_the_pipe = $outer_diameter_of_the_pipe;

        return $this;
    }

    public function getPipeWallThickness(): ?int
    {
        return $this->pipe_wall_thickness;
    }

    public function setPipeWallThickness(?int $pipe_wall_thickness): self
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

    public function getRefPipeStrengthGroup(): ?RefPipeStrengthGroup
    {
        return $this->ref_pipe_strength_group;
    }

    public function setRefPipeStrengthGroup(?RefPipeStrengthGroup $ref_pipe_strength_group): self
    {
        $this->ref_pipe_strength_group = $ref_pipe_strength_group;

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

    public function getOdlockNipple(): ?int
    {
        return $this->odlock_nipple;
    }

    public function setOdlockNipple(?int $odlock_nipple): self
    {
        $this->odlock_nipple = $odlock_nipple;

        return $this;
    }

    public function getDfchamferNipple(): ?int
    {
        return $this->dfchamfer_nipple;
    }

    public function setDfchamferNipple(?int $dfchamfer_nipple): self
    {
        $this->dfchamfer_nipple = $dfchamfer_nipple;

        return $this;
    }

    public function getLpcThreadLengthNipple(): ?int
    {
        return $this->lpc_thread_length_nipple;
    }

    public function setLpcThreadLengthNipple(?int $lpc_thread_length_nipple): self
    {
        $this->lpc_thread_length_nipple = $lpc_thread_length_nipple;

        return $this;
    }

    public function getNippleNoseDiameter(): ?int
    {
        return $this->nipple_nose_diameter;
    }

    public function setNippleNoseDiameter(?int $nipple_nose_diameter): self
    {
        $this->nipple_nose_diameter = $nipple_nose_diameter;

        return $this;
    }

    public function getOdlockCoupling(): ?int
    {
        return $this->odlock_coupling;
    }

    public function setOdlockCoupling(?int $odlock_coupling): self
    {
        $this->odlock_coupling = $odlock_coupling;

        return $this;
    }

    public function getDfchamferCoupling(): ?int
    {
        return $this->dfchamfer_coupling;
    }

    public function setDfchamferCoupling(?int $dfchamfer_coupling): self
    {
        $this->dfchamfer_coupling = $dfchamfer_coupling;

        return $this;
    }

    public function getLbcThreadLengthCoupler(): ?int
    {
        return $this->lbc_thread_length_coupler;
    }

    public function setLbcThreadLengthCoupler(?int $lbc_thread_length_coupler): self
    {
        $this->lbc_thread_length_coupler = $lbc_thread_length_coupler;

        return $this;
    }

    public function getQcBoreDiameterCoupling(): ?int
    {
        return $this->qc_bore_diameter_coupling;
    }

    public function setQcBoreDiameterCoupling(?int $qc_bore_diameter_coupling): self
    {
        $this->qc_bore_diameter_coupling = $qc_bore_diameter_coupling;

        return $this;
    }

    public function getIdlockNipple(): ?int
    {
        return $this->idlock_nipple;
    }

    public function setIdlockNipple(?int $idlock_nipple): self
    {
        $this->idlock_nipple = $idlock_nipple;

        return $this;
    }

    public function getPipeLength(): ?int
    {
        return $this->pipe_length;
    }

    public function setPipeLength(?int $pipe_length): self
    {
        $this->pipe_length = $pipe_length;

        return $this;
    }

    public function getWeightOfPipe(): ?int
    {
        return $this->weight_of_pipe;
    }

    public function setWeightOfPipe(?int $weight_of_pipe): self
    {
        $this->weight_of_pipe = $weight_of_pipe;

        return $this;
    }

    public function getShoulderAngle(): ?int
    {
        return $this->shoulder_angle;
    }

    public function setShoulderAngle(?int $shoulder_angle): self
    {
        $this->shoulder_angle = $shoulder_angle;

        return $this;
    }

    public function getTurnkeyLengthNipple(): ?int
    {
        return $this->turnkey_length_nipple;
    }

    public function setTurnkeyLengthNipple(?int $turnkey_length_nipple): self
    {
        $this->turnkey_length_nipple = $turnkey_length_nipple;

        return $this;
    }

    public function getTurnkeyLengthCoupling(): ?int
    {
        return $this->turnkey_length_coupling;
    }

    public function setTurnkeyLengthCoupling(?int $turnkey_length_coupling): self
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

    public function getBtCertificateNumber(): ?string
    {
        return $this->bt_certificate_number;
    }

    public function setBtCertificateNumber(?string $bt_certificate_number): self
    {
        $this->bt_certificate_number = $bt_certificate_number;

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

    public function getDepthOfNaminov(): ?int
    {
        return $this->depth_of_naminov;
    }

    public function setDepthOfNaminov(?int $depth_of_naminov): self
    {
        $this->depth_of_naminov = $depth_of_naminov;

        return $this;
    }

    public function getNippleEndBendMax(): ?int
    {
        return $this->nipple_end_bend_max;
    }

    public function setNippleEndBendMax(?int $nipple_end_bend_max): self
    {
        $this->nipple_end_bend_max = $nipple_end_bend_max;

        return $this;
    }

    public function getCouplingEndBendMax(): ?int
    {
        return $this->coupling_end_bend_max;
    }

    public function setCouplingEndBendMax(?int $coupling_end_bend_max): self
    {
        $this->coupling_end_bend_max = $coupling_end_bend_max;

        return $this;
    }

    public function getTheTotalBendOfThePipeBodyMax(): ?int
    {
        return $this->the_total_bend_of_the_pipe_body_max;
    }

    public function setTheTotalBendOfThePipeBodyMax(?int $the_total_bend_of_the_pipe_body_max): self
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

    public function getHardbandingNipplemmDiameter(): ?int
    {
        return $this->hardbanding_nipplemm_diameter;
    }

    public function setHardbandingNipplemmDiameter(?int $hardbanding_nipplemm_diameter): self
    {
        $this->hardbanding_nipplemm_diameter = $hardbanding_nipplemm_diameter;

        return $this;
    }

    public function getHardbandingNippleHeight(): ?int
    {
        return $this->hardbanding_nipple_height;
    }

    public function setHardbandingNippleHeight(?int $hardbanding_nipple_height): self
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

    public function getHardbandingCouplerDiameter(): ?int
    {
        return $this->hardbanding_coupler_diameter;
    }

    public function setHardbandingCouplerDiameter(?int $hardbanding_coupler_diameter): self
    {
        $this->hardbanding_coupler_diameter = $hardbanding_coupler_diameter;

        return $this;
    }

    public function getHardbandingCouplingHeightMm(): ?int
    {
        return $this->hardbanding_coupling_height_mm;
    }

    public function setHardbandingCouplingHeightMm(?int $hardbanding_coupling_height_mm): self
    {
        $this->hardbanding_coupling_height_mm = $hardbanding_coupling_height_mm;

        return $this;
    }

    public function getLockClassCoupling(): ?int
    {
        return $this->lock_class_coupling;
    }

    public function setLockClassCoupling(?int $lock_class_coupling): self
    {
        $this->lock_class_coupling = $lock_class_coupling;

        return $this;
    }

    public function getMinTheWidthThrustShoulder(): ?int
    {
        return $this->min_the_width_thrust_shoulder;
    }

    public function setMinTheWidthThrustShoulder(?int $min_the_width_thrust_shoulder): self
    {
        $this->min_the_width_thrust_shoulder = $min_the_width_thrust_shoulder;

        return $this;
    }

    public function getMinWidthStopShoulder(): ?int
    {
        return $this->min_width_stop_shoulder;
    }

    public function setMinWidthStopShoulder(?int $min_width_stop_shoulder): self
    {
        $this->min_width_stop_shoulder = $min_width_stop_shoulder;

        return $this;
    }

    public function getMinLengthTransitionSection(): ?int
    {
        return $this->min_length_transition_section;
    }

    public function setMinLengthTransitionSection(?int $min_length_transition_section): self
    {
        $this->min_length_transition_section = $min_length_transition_section;

        return $this;
    }

    public function getRefLabelResurfacing(): ?RefLabelResurfacing
    {
        return $this->ref_label_resurfacing;
    }

    public function setRefLabelResurfacing(?RefLabelResurfacing $ref_label_resurfacing): self
    {
        $this->ref_label_resurfacing = $ref_label_resurfacing;

        return $this;
    }

    public function getTheMinimumMoment(): ?int
    {
        return $this->the_minimum_moment;
    }

    public function setTheMinimumMoment(?int $the_minimum_moment): self
    {
        $this->the_minimum_moment = $the_minimum_moment;

        return $this;
    }

    public function getTheMaximumMoment(): ?int
    {
        return $this->the_maximum_moment;
    }

    public function setTheMaximumMoment(?int $the_maximum_moment): self
    {
        $this->the_maximum_moment = $the_maximum_moment;

        return $this;
    }

    public function getTheLimitingMoment(): ?int
    {
        return $this->the_limiting_moment;
    }

    public function setTheLimitingMoment(?int $the_limiting_moment): self
    {
        $this->the_limiting_moment = $the_limiting_moment;

        return $this;
    }

    public function getTheUltimateTensile(): ?int
    {
        return $this->the_ultimate_tensile;
    }

    public function setTheUltimateTensile(?int $the_ultimate_tensile): self
    {
        $this->the_ultimate_tensile = $the_ultimate_tensile;

        return $this;
    }

    public function getTheUltimateTorqueOfTheTube(): ?int
    {
        return $this->the_ultimate_torque_of_the_tube;
    }

    public function setTheUltimateTorqueOfTheTube(?int $the_ultimate_torque_of_the_tube): self
    {
        $this->the_ultimate_torque_of_the_tube = $the_ultimate_torque_of_the_tube;

        return $this;
    }

    public function getTheUltimateTensileLoadOfThePipe(): ?int
    {
        return $this->the_ultimate_tensile_load_of_the_pipe;
    }

    public function setTheUltimateTensileLoadOfThePipe(?int $the_ultimate_tensile_load_of_the_pipe): self
    {
        $this->the_ultimate_tensile_load_of_the_pipe = $the_ultimate_tensile_load_of_the_pipe;

        return $this;
    }
}
