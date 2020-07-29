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
use App\Entity\Repair;
use App\Entity\TaskCardOtherField;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Serializer\Annotation\Groups;
use Swagger\Annotations as SWG;

trait CardTrait
{
    /**
     * Полное название карточки
     *
     * @var string
     * @api Поле нужно только для документации
     * @see CardTrait::getGeneralName()
     * @SWG\Property(property="fullName")
     */
    private $generalName;

    /**
     * Ссылки на изображения
     *
     * @var string[]
     * @api Поле нужно только для документации
     * @see CardTrait::getImagesLink()
     */
    private $imagesLink;

    /**
     * Комментарий/Примечание
     *
     * @var string
     * @api Поле нужно только для документации
     * @see CardTrait::getComment()
     */
    private $comment;

    /**
     * Название класса родительской задачи.
     * Если карточка вызваеться через задачу
     *
     * @var string
     */
    private $taskClassName;

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

    public function getStatusTitle()
    {
        return CardStatusHelper::STATUS_TITLE[$this->status] ?? 'Статус не задан';
    }

    /**
     * Получаем дополнительные поля с привязкой к задаче и фильтруем по типу задачи
     * @param TaskItemInterface $task
     * @return TaskCardOtherField
     * @see app/templates/marking/show.html.twig:38
     */
    public function getTaskCardOtherFieldsByTask($task): TaskCardOtherField
    {
        if(is_object($task)) {
            $taskClass = get_class($task);
        } else {
            $taskClass = $task;
        }
        $taskTypeId = TaskHelper::ins()->getTypeByEntityClass($taskClass);
        $criteria = Criteria::create()->where(Criteria::expr()->eq("taskTypeId", $taskTypeId));

        return $this->getTaskCardOtherFields()->matching($criteria)->first() ?: new TaskCardOtherField();
    }

    /**
     * @see CardTrait::$imagesLink
     *
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     *
     * @return array
     */
    public function getImagesLink()
    {
        return MediaHelper::ins()->getImageLink($this->getImages());
    }

    /**
     * @see CardTrait::$comment
     *
     * @Groups({\App\Classes\ApiParentController::GROUP_API_DEFAULT})
     *
     * @return string
     */
    public function getComment()
    {
        if($this->getTaskClassName()) {
            return $this->getTaskCardOtherFieldsByTask($this->getTaskClassName())->getComment();
        }

        return '';
    }

    /**
     * @return mixed
     */
    public function getTaskClassName()
    {
        return $this->taskClassName;
    }

    /**
     * @param mixed $taskClassName
     * @return $this
     */
    public function setTaskClassName($taskClassName)
    {
        $this->taskClassName = $taskClassName;
        return $this;
    }

    public function repairCardImgRequiredInput(string $formId, Repair $repair)
    {
        static $counter = 0;
        $formId = preg_replace('/\_.*$/', '', $formId);
        $isChecked = $this->getRepairCardImgRequiredByRepair($repair)->getRequired();
        $checked = '';
        if($isChecked) {
            $checked = 'checked="checked"';
        }
        $result = '
        <input name="' . $formId . '[cardImgRequired][' . $counter .'][required]" class="form-check-input" type="checkbox" value="1" ' . $checked . '>
        <input type="hidden" name="' . $formId . '[cardImgRequired][' . $counter .'][card]" value="' . $this->getId() .'">
        ';
        $counter++;
        return $result;
    }

}