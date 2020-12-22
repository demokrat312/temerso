<?php


namespace App\Classes\Equipment;


use App\Entity\Card;
use App\Entity\EquipmentKit;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @mixin EquipmentKit
 */
trait EquipmentKitTrait
{
    /**
     * Список подтвержденных карточек
     *
     * @var Card[]
     * @api Поле нужно только для документации
     * @see EquipmentKitTrait::getCardListConfirmed()
     */
    private $cardListConfirmed;

    /**
     * Список подтвержденных карточек
     *
     * @var Card[]
     * @api Поле нужно только для документации
     * @see EquipmentKitTrait::getCardListNotConfirmed()
     */
    private $cardListNotConfirmed;

    /**
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     * @see CardTrait::$generalName
     */
    public function getCardListConfirmed()
    {
        return $this->getEquipment()->getCardsFilterConfirmed($this);
    }

    /**
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     * @see CardTrait::$generalName
     */
    public function getCardListNotConfirmed()
    {
        return $this->getEquipment()->getCardsFilterNotConfirmed($this);
    }
}