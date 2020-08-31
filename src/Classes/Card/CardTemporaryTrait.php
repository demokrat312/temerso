<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 26.04.2020
 * Time: 20:40
 */

namespace App\Classes\Card;


use App\Classes\MediaHelper;
use App\Classes\Task\TaskHelper;
use App\Classes\Task\TaskItemInterface;
use App\Entity\CardTemporary;
use App\Entity\Repair;
use App\Entity\RepairCardImgRequired;
use App\Entity\TaskCardOtherField;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;
use App\Classes\Card\CardIdentificationResponse;
use App\Classes\ApiParentController;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @mixin CardTemporary
 */
trait CardTemporaryTrait
{
    /**
     * Ключ, карточки
     *
     * @var int
     * @Groups({ApiParentController::GROUP_API_DEFAULT})
     * @SerializedName("id")
     */
    private $cardId;
    /**
     * Полное название карточки
     *
     * @var string
     * @api Поле нужно только для документации
     * @see CardTrait::getGeneralName()
     */
    private $generalName;

    /**
     * Полное название карточки
     *
     * @var string
     * @api Поле нужно только для документации. Дублирует поле generalName
     * @see CardTrait::getFullName()
     * @Groups({CardIdentificationResponse::GROUP_API_DEFAULT})
     */
    private $fullName;

    /**
     * @return int
     */
    public function getCardId(): int
    {
        return $this->card->getId();
    }

    public function __toString()
    {
        return sprintf('Карточка: %s', $this->getId());
    }


    /**
     *
     * Тип оборудования + Тип высадки (без запятой), Наружный диаметр трубы, (мм) *  Толщина стенки трубы,
     * (мм)  (вывод информации в формате 88,9*8,0),  Тип резьбы + помещенная в скобки информация
     * (O.D. Замка ниппель  (мм) *I.D. Замка ниппель  (мм), вывод информации в формате (108х50,8)),
     * Длина трубы в формате: L=8,3-8,6м, где 8,3-8,6 - значение характеристики,
     * Угол заплетчика в формате: Наименование характеристики + значение характеристики + знак градуса '°',
     * Наменование характеристики 'Длина под ключ ниппель, (мм)' + значение характеристики,
     * Наменование характеристики 'Длина под ключ муфта, (мм)' + значение характеристики, Покрытие резьбы,
     * Внутреннее покрытие,  Хардбендинг (муфта)
     *
     * ПРИМЕР:
     *
     * БТ  IU, 88,9*8,0, S-135, Z83-DS (108х50,8), L=8,3-8,6м, угол заплечика 90° , размер под ключ ниппель-330 мм,
     * размер под ключ муфта-381 мм, ТДЦ, TC2000, TCS Titanium
     *
     * @return string
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     * @see CardTrait::$generalName
     */
    public function getGeneralName()
    {
        return implode(' ', [
            'Тип оборудования' => $this->getRefTypeEquipment(), // БТ
            'Тип высадки (без запятой)' => $this->getRefTypeDisembarkation() . ', ', // IU,
            'Наружный диаметр трубы, (мм) *' => $this->getOuterDiameterOfThePipe() . '*', // 88,9*
            'Толщина стенки трубы(мм),(вывод информации в формате 88,9*8,0),' => $this->getPipeWallThickness() . ', ', // 8,0,
            'Тип резьбы' => $this->getRefTypeThread(), // S-135
            // Z83-DS (108х50,8)
            'помещенная в скобки информация * (O.D. Замка ниппель  (мм) *I.D. Замка ниппель  (мм), вывод информации в формате (108х50,8))' =>
                '(' . $this->getOdlockNipple() . 'x' . $this->getIdlockNipple() . '), '
            ,
            'Длина трубы в формате: L=8,3-8,6м, где 8,3-8,6 - значение характеристики' => 'L=' . $this->getPipeLength() . 'м, ', // L=8,3-8,6м
            // угол заплечика 90 °,
            'Угол заплетчика в формате: Наименование характеристики + значение характеристики + знак градуса °, ' =>
                'Угол заплечика ' . $this->getShoulderAngle() . '°,'
            ,
            // размер под ключ ниппель-330 мм,
            'Наменование характеристики \'Длина под ключ ниппель, (мм)\' + Длина под ключ ниппель, ' =>
                'Длина под ключ ниппель, (мм) ' . $this->getTurnkeyLengthNipple() . ', '
            ,
            // размер под ключ муфта-381 мм,
            'Наменование характеристики \'Длина под ключ муфта, (мм)\' + значение характеристики, Покрытие резьбы,' =>
                'Длина под ключ муфта, (мм)' . $this->getTurnkeyLengthCoupling() . ', '
            ,
            'Покрытие резьбы,' => $this->getRefThreadCoating() . ', ', // ТДЦ,
            'Внутреннее покрытие, ' => $this->getRefInnerCoating() . ', ', // TC2000,
            'Хардбендинг (муфта)   ' => $this->getRefHardbandingCoupling(), // TCS Titanium,
        ]);
    }

    /**
     * @Groups({CardIdentificationResponse::GROUP_API_DEFAULT})
     * @see CardTrait::$fullName
     * @return string
     */
    public function getFullName() {
        return $this->getGeneralName();
    }
}