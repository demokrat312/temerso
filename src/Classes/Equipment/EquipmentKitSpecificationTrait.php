<?php


namespace App\Classes\Equipment;


use App\Entity\EquipmentKitSpecification;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @mixin EquipmentKitSpecification
 */
trait EquipmentKitSpecificationTrait
{
    /**
     * Тип оборудования, название
     *
     * @var string
     * @api Поле нужно только для документации
     * @see EquipmentKitSpecificationTrait::getRefTypeEquipmentTitle()
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $refTypeEquipmentTitle;
    /**
     * Тип высадки, название
     *
     * @var string
     * @api Поле нужно только для документации
     * @see EquipmentKitSpecificationTrait::getRefTypeDisembarkationTitle()
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $refTypeDisembarkationTitle;
    /**
     * Тип резьбы, название
     *
     * @var string
     * @api Поле нужно только для документации
     * @see EquipmentKitSpecificationTrait::getRefTypeThreadTitle()
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $refTypeThreadTitle;
    /**
     * Покрытие резьбы, название
     *
     * @var string
     * @api Поле нужно только для документации
     * @see EquipmentKitSpecificationTrait::getRefThreadCoatingTitle()
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $refThreadCoatingTitle;
    /**
     * Внутреннее покрытие, название
     *
     * @var string
     * @api Поле нужно только для документации
     * @see EquipmentKitSpecificationTrait::getRefInnerCoatingTitle()
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $refInnerCoatingTitle;
    /**
     * Хардбендинг (муфта), название
     *
     * @var string
     * @api Поле нужно только для документации
     * @see EquipmentKitSpecificationTrait::getRefHardbandingCouplingTitle()
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     */
    private $refHardbandingCouplingTitle;

    /**
     * @return string
     * @see EquipmentKitSpecificationTrait::refTypeEquipmentTitle
     */
    public function getRefTypeEquipmentTitle(): string
    {
        return $this->refTypeEquipment ? $this->refTypeEquipment->getValue() : '';
    }

    /**
     * @return string
     * @see EquipmentKitSpecificationTrait::refTypeDisembarkationTitle
     */
    public function getRefTypeDisembarkationTitle(): string
    {
        return $this->refTypeDisembarkation ? $this->refTypeDisembarkation->getValue() : '';
    }

    /**
     * @return string
     * @see EquipmentKitSpecificationTrait::refTypeThreadTitle
     */
    public function getRefTypeThreadTitle(): string
    {
        return $this->refTypeThread ? $this->refTypeThread->getValue() : '';
    }

    /**
     * @return string
     * @see EquipmentKitSpecificationTrait::refThreadCoatingTitle
     */
    public function getRefThreadCoatingTitle(): string
    {
        return $this->refThreadCoating ? $this->refThreadCoating->getValue() : '';
    }

    /**
     * @return string
     * @see EquipmentKitSpecificationTrait::refInnerCoatingTitle
     */
    public function getRefInnerCoatingTitle(): string
    {
        return $this->refInnerCoating ? $this->refInnerCoating->getValue() : '';
    }

    /**
     * @return string
     * @see EquipmentKitSpecificationTrait::refHardbandingCouplingTitle
     */
    public function getRefHardbandingCouplingTitle(): string
    {
        return $this->refHardbandingCoupling ? $this->refHardbandingCoupling->getValue() : '';
    }


}