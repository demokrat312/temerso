<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 26.04.2020
 * Time: 20:40
 */

namespace App\Classes;


use App\Classes\Task\TaskHelper;
use App\Classes\Task\TaskItemInterface;
use App\Entity\TaskCardOtherField;
use Doctrine\Common\Collections\Criteria;

trait CardTrait
{
    private $generalName;

    public function __toString()
    {
        return (string)$this->getStatusTitle();
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

    public function getStatusTitle()
    {
        return StatusHelper::STATUS_TITLE[$this->status] ?? 'Статус не задан';
    }

    /**
     * Получаем дополнительные поля с привязкой к задаче и фильтруем по типу задачи
     * @param TaskItemInterface $task
     * @return TaskCardOtherField
     * @see app/templates/marking/show.html.twig:38
     */
    public function getTaskCardOtherFieldsByTask(TaskItemInterface $task): TaskCardOtherField
    {
        $taskTypeId = TaskHelper::ins()->getTypeByEntityClass(get_class($task));
        $criteria = Criteria::create()->where(Criteria::expr()->eq("taskTypeId", $taskTypeId));

        return $this->getTaskCardOtherFields()->matching($criteria)->first() ?: new TaskCardOtherField();
    }
}