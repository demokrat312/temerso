<?php

namespace App\Entity;

use App\Application\Sonata\MediaBundle\Entity\Media;
use App\Classes\Arrival\ArrivalTrait;
use App\Entity\Reference\RefHardbandingNipple;
use App\Entity\Reference\RefInnerCoating;
use App\Entity\Reference\RefPipeStrengthGroup;
use App\Entity\Reference\RefThreadCoating;
use App\Entity\Reference\RefTypeDisembarkation;
use App\Entity\Reference\RefTypeEquipment;
use App\Entity\Reference\RefTypeThread;
use App\Entity\Reference\RefWearClass;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Приход
 *
 * @ORM\Entity(repositoryClass="App\Repository\ArrivalRepository")
 */
class Arrival
{
    use ArrivalTrait;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Дата создания для системы
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * Карточки
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Card", mappedBy="arrival")
     */
    private $cards;

    /**
     * Вторая форма.
     * Количество карточек, которые будем генерировать
     *
     * @ORM\Column(type="integer")
     */
    private $amountCard;

    /**
     * Первыя форма.
     * Дата прихода
     *
     * @ORM\Column(type="string", length=255)
     */
    private $dateArrival;

    /**
     * Первыя форма.
     * № договора покупки, дата покупки
     *
     * @ORM\Column(type="string", length=255)
     */
    private $numberAndDatePurchase;


    /**
     * Первыя форма.
     * Приложение сканов
     *
     * @ORM\ManyToMany(targetEntity="App\Application\Sonata\MediaBundle\Entity\Media",cascade={"persist"})
     * @ORM\JoinTable(
     *     name="arrival_file_media",
     *     joinColumns={
     *          @ORM\JoinColumn(name="arrival_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     *     }
     * )
     * @Assert\Count(min = 1, minMessage = "Укажите файл")
     */
    private $files;

    /**
     * Вторая форма. Общие поля для карточекТип оборудования (выбор значений из списка)
     * Тип оборудования (выбор значений из списка)
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefTypeEquipment")
     */
    private $refTypeEquipment;

    /**
     * Вторая форма. Общие поля для карточекМестоположение оборудования
     * Местоположение оборудования
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * Вторая форма. Общие поля для карточекНаработка моточасов (числовое поле)
     * Наработка моточасов (числовое поле)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $operatingHours;

    /**
     * Вторая форма. Общие поля для карточекНаружный диаметр трубы, (мм)
     * Наружный диаметр трубы, (мм)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $outerDiameterOfThePipe;

    /**
     * Вторая форма. Общие поля для карточекТолщина стенки трубы, (мм)
     * Толщина стенки трубы, (мм)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $pipeWallThickness;

    /**
     * Вторая форма. Общие поля для карточекТип высадки
     * Тип высадки
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefTypeDisembarkation")
     */
    private $refTypeDisembarkation;

    /**
     * Вторая форма. Общие поля для карточекГруппа прочности трубы
     * Группа прочности трубы
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefPipeStrengthGroup")
     */
    private $refPipeStrengthGroup;

    /**
     * Вторая форма. Общие поля для карточекТип резьбы
     * Тип резьбы
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefTypeThread")
     */
    private $refTypeThread;

    /**
     * Вторая форма. Общие поля для карточекO.D. Замка ниппель  (мм)
     * O.D. Замка ниппель  (мм)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $odlockNipple;

    /**
     * Вторая форма. Общие поля для карточекD.F.  Фаска ниппель (мм)
     * D.F.  Фаска ниппель (мм)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $dfchamferNipple;

    /**
     * Вторая форма. Общие поля для карточекLPC   Длина резьбы ниппель (мм)
     * LPC   Длина резьбы ниппель (мм)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $lpcThreadLengthNipple;

    /**
     * Вторая форма. Общие поля для карточекДиаметр носика ниппеля
     * Диаметр носика ниппеля
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $nippleNoseDiameter;

    /**
     * Вторая форма. Общие поля для карточекO.D. Замка муфта  (мм)
     * O.D. Замка муфта  (мм)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $odlockCoupling;

    /**
     * Вторая форма. Общие поля для карточекD.F.  Фаска муфта (мм)
     * D.F.  Фаска муфта (мм)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $dfchamferCoupling;

    /**
     * Вторая форма. Общие поля для карточекLBC Длина резьбы муфта (мм)
     * LBC Длина резьбы муфта (мм)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $lbcThreadLengthCoupler;

    /**
     * Вторая форма. Общие поля для карточекQC Диаметр расточки муфта(мм)
     * QC Диаметр расточки муфта(мм)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $qcBoreDiameterCoupling;

    /**
     * Вторая форма. Общие поля для карточекI.D. Замка ниппель  (мм)
     * I.D. Замка ниппель  (мм)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $idlockNipple;

    /**
     * Вторая форма. Общие поля для карточекУгол заплечика (градус)
     * Угол заплечика (градус)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $shoulderAngle;

    /**
     * Вторая форма. Общие поля для карточекДлина под ключ ниппель, (мм)
     * Длина под ключ ниппель, (мм)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $turnkeyLengthNipple;

    /**
     * Вторая форма. Общие поля для карточекДлина под ключ муфта, (мм)
     * Длина под ключ муфта, (мм)
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $turnkeyLengthCoupling;

    /**
     * Вторая форма. Общие поля для карточекПокрытие резьбы
     * Покрытие резьбы
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefThreadCoating")
     */
    private $refThreadCoating;

    /**
     * Вторая форма. Общие поля для карточекВнутреннее покрытие
     * Внутреннее покрытие
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefInnerCoating")
     */
    private $refInnerCoating;

    /**
     * Вторая форма. Общие поля для карточекХардбендинг (ниппель)
     * Хардбендинг (ниппель)
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefHardbandingNipple")
     */
    private $refHardbandingNipple;

    /**
     * Вторая форма. Общие поля для карточекХардбендинг (муфта)
     * Хардбендинг (муфта)
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefHardbandingNipple")
     */
    private $refHardbandingCoupling;

    /**
     * Вторая форма. Общие поля для карточекНомер Сертификата на комплект БТ
     * Номер Сертификата на комплект БТ
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $btCertificateNumber;

    /**
     * Вторая форма. Общие поля для карточекКласс износа
     * Класс износа
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Reference\RefWearClass")
     */
    private $refWearClass;

    /**
     * Первая форма. Количество единиц товара в партии
     *
     * @ORM\Column(type="integer")
     */
    private $numberUnitsInBatch;

    /**
     * Третья форма. Свои значения для каждной карточки
     * Серийные номера группы труб
     *
     * @ORM\Column(type="text")
     */
    private $groupPipeSerialNumber;

    /**
     * Третья форма. Свои значения для каждной карточки
     * Серийные номера группы ниппелей
     *
     * @ORM\Column(type="text")
     */
    private $groupSerialNoOfNipple;

    /**
     * Третья форма. Свои значения для каждной карточки
     * Серийные номера группы муфт
     *
     * @ORM\Column(type="text")
     */
    private $groupCouplingSerialNumber;

    /**
     * Третья форма. Свои значения для каждной карточки
     * Длина трубы
     *
     * @ORM\Column(type="text")
     */
    private $groupPipeLength;

    /**
     * Третья форма. Свои значения для каждной карточки
     * Вес трубы
     *
     * @ORM\Column(type="text")
     */
    private $groupWeightOfPipe;

    public function __construct()
    {
        $this->createdAt = new DateTime('NOW');
        $this->cards = new ArrayCollection();
        $this->files = new ArrayCollection();

        // Значения по умолчанию
        $this->location = 'Открытая складская площадка';
    }

    public function __toString()
    {
        return $this->getNumberAndDatePurchase();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Card[]
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->setArrival($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            // set the owning side to null (unless already changed)
            if ($card->getArrival() === $this) {
                $card->setArrival(null);
            }
        }

        return $this;
    }

    public function getAmountCard(): ?int
    {
        return $this->amountCard;
    }

    public function setAmountCard(int $amountCard): self
    {
        $this->amountCard = $amountCard;

        return $this;
    }

    public function getDateArrival(): ?string
    {
        return $this->dateArrival;
    }

    public function setDateArrival(string $dateArrival): self
    {
        $this->dateArrival = $dateArrival;

        return $this;
    }

    public function getNumberAndDatePurchase(): ?string
    {
        return $this->numberAndDatePurchase;
    }

    public function setNumberAndDatePurchase(string $numberAndDatePurchase): self
    {
        $this->numberAndDatePurchase = $numberAndDatePurchase;

        return $this;
    }

    /**
     * @return Collection|Media[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile($file): self
    {
        if ($file && !$this->files->contains($file)) {
            $this->files[] = $file;
        }

        return $this;
    }

    public function removeFile(Media $file): self
    {
        if ($this->files->contains($file)) {
            $this->files->removeElement($file);
        }

        return $this;
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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getOperatingHours(): ?float
    {
        return $this->operatingHours;
    }

    public function setOperatingHours(?float $operatingHours): self
    {
        $this->operatingHours = $operatingHours;

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

    public function getRefTypeDisembarkation(): ?RefTypeDisembarkation
    {
        return $this->refTypeDisembarkation;
    }

    public function setRefTypeDisembarkation(?RefTypeDisembarkation $refTypeDisembarkation): self
    {
        $this->refTypeDisembarkation = $refTypeDisembarkation;

        return $this;
    }

    public function getRefPipeStrengthGroup(): ?RefPipeStrengthGroup
    {
        return $this->refPipeStrengthGroup;
    }

    public function setRefPipeStrengthGroup(?RefPipeStrengthGroup $refPipeStrengthGroup): self
    {
        $this->refPipeStrengthGroup = $refPipeStrengthGroup;

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

    public function getDfchamferNipple(): ?float
    {
        return $this->dfchamferNipple;
    }

    public function setDfchamferNipple(?float $dfchamferNipple): self
    {
        $this->dfchamferNipple = $dfchamferNipple;

        return $this;
    }

    public function getLpcThreadLengthNipple(): ?float
    {
        return $this->lpcThreadLengthNipple;
    }

    public function setLpcThreadLengthNipple(?float $lpcThreadLengthNipple): self
    {
        $this->lpcThreadLengthNipple = $lpcThreadLengthNipple;

        return $this;
    }

    public function getNippleNoseDiameter(): ?float
    {
        return $this->nippleNoseDiameter;
    }

    public function setNippleNoseDiameter(?float $nippleNoseDiameter): self
    {
        $this->nippleNoseDiameter = $nippleNoseDiameter;

        return $this;
    }

    public function getOdlockCoupling(): ?float
    {
        return $this->odlockCoupling;
    }

    public function setOdlockCoupling(?float $odlockCoupling): self
    {
        $this->odlockCoupling = $odlockCoupling;

        return $this;
    }

    public function getDfchamferCoupling(): ?float
    {
        return $this->dfchamferCoupling;
    }

    public function setDfchamferCoupling(?float $dfchamferCoupling): self
    {
        $this->dfchamferCoupling = $dfchamferCoupling;

        return $this;
    }

    public function getLbcThreadLengthCoupler(): ?float
    {
        return $this->lbcThreadLengthCoupler;
    }

    public function setLbcThreadLengthCoupler(?float $lbcThreadLengthCoupler): self
    {
        $this->lbcThreadLengthCoupler = $lbcThreadLengthCoupler;

        return $this;
    }

    public function getQcBoreDiameterCoupling(): ?float
    {
        return $this->qcBoreDiameterCoupling;
    }

    public function setQcBoreDiameterCoupling(?float $qcBoreDiameterCoupling): self
    {
        $this->qcBoreDiameterCoupling = $qcBoreDiameterCoupling;

        return $this;
    }

    public function getIdlockNipple()
    {
        return $this->idlockNipple;
    }

    public function setIdlockNipple($idlockNipple): self
    {
        $this->idlockNipple = $idlockNipple;

        return $this;
    }

    public function getShoulderAngle(): ?float
    {
        return $this->shoulderAngle;
    }

    public function setShoulderAngle(?float $shoulderAngle): self
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

    public function getRefHardbandingNipple(): ?RefHardbandingNipple
    {
        return $this->refHardbandingNipple;
    }

    public function setRefHardbandingNipple(?RefHardbandingNipple $refHardbandingNipple): self
    {
        $this->refHardbandingNipple = $refHardbandingNipple;

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

    public function getBtCertificateNumber(): ?string
    {
        return $this->btCertificateNumber;
    }

    public function setBtCertificateNumber(?string $btCertificateNumber): self
    {
        $this->btCertificateNumber = $btCertificateNumber;

        return $this;
    }

    public function getRefWearClass(): ?RefWearClass
    {
        return $this->refWearClass;
    }

    public function setRefWearClass(?RefWearClass $refWearClass): self
    {
        $this->refWearClass = $refWearClass;

        return $this;
    }

    public function getNumberUnitsInBatch(): ?int
    {
        return $this->numberUnitsInBatch;
    }

    public function setNumberUnitsInBatch(int $numberUnitsInBatch): self
    {
        $this->numberUnitsInBatch = $numberUnitsInBatch;

        return $this;
    }

    public function getGroupPipeSerialNumber(): ?string
    {
        return $this->groupPipeSerialNumber;
    }

    public function setGroupPipeSerialNumber(string $groupPipeSerialNumber): self
    {
        $this->groupPipeSerialNumber = $groupPipeSerialNumber;

        return $this;
    }

    public function getGroupSerialNoOfNipple(): ?string
    {
        return $this->groupSerialNoOfNipple;
    }

    public function setGroupSerialNoOfNipple(string $groupSerialNoOfNipple): self
    {
        $this->groupSerialNoOfNipple = $groupSerialNoOfNipple;

        return $this;
    }

    public function getGroupCouplingSerialNumber(): ?string
    {
        return $this->groupCouplingSerialNumber;
    }

    public function setGroupCouplingSerialNumber(string $groupCouplingSerialNumber): self
    {
        $this->groupCouplingSerialNumber = $groupCouplingSerialNumber;

        return $this;
    }

    public function getGroupPipeLength(): ?string
    {
        return $this->groupPipeLength;
    }

    public function setGroupPipeLength(string $groupPipeLength): self
    {
        $this->groupPipeLength = $groupPipeLength;

        return $this;
    }

    public function getGroupWeightOfPipe(): ?string
    {
        return $this->groupWeightOfPipe;
    }

    public function setGroupWeightOfPipe(string $groupWeightOfPipe): self
    {
        $this->groupWeightOfPipe = $groupWeightOfPipe;

        return $this;
    }
}
