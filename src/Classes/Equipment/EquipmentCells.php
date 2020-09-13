<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 06.05.2020
 * Time: 12:55
 */

namespace App\Classes\Equipment;


use App\Classes\Excel\ParentCells;
use App\Classes\Task\TaskItemInterface;
use App\Entity\Card;
use App\Entity\Equipment;
use App\Entity\EquipmentKit;
use Doctrine\Common\Collections\Collection;

class EquipmentCells extends ParentCells
{
    /**
     * @var Equipment
     */
    private $equipment;

    /**
     * Дата прихода
     *
     * @param $value
     */
    public function setGeneral(Equipment $equipment)
    {
        $this->equipment = $equipment;

        $this->sheet->setCellValue('B1', $this->getCardSpecified()); // Задано в комплект (суммарное число единиц оборудования, которое указал постановщик задачи)
        $this->sheet->setCellValue('B2', $equipment->getTotalCardWithCatalog()); // Отобрано в комплект (суммарное число единиц оборудования, которое находится в единичном или множественном комплекте (сумма подкомплектов))
        $this->sheet->setCellValue('B3', $equipment->getTenantName()); // значение поля ‘Название компании-арендатора’
        $this->sheet->setCellValue('B4', $equipment->getMainReason()); // значение поля ‘Основание формирования комплекта’

        return $this;
    }

    /**
     * @param Collection|Card[] $cards
     */
    public function setCars(int $startRow, Equipment $equipment, EquipmentKit $equipmentKit)
    {
        $rowCount = $startRow;
        $equipment->getCardsFilterConfirmed($equipmentKit)->map(function (Card $card) use ($equipment, &$rowCount) {
            $this->sheet->setCellValue('A' . $rowCount, $card->getGeneralName()); // Наименованеие
            $this->sheet->setCellValue('B' . $rowCount, $card->getPipeSerialNumber()); // Серийный № трубы
            $this->sheet->setCellValue('C' . $rowCount, $card->getSerialNoOfNipple()); // Серийный № ниппеля
            $this->sheet->setCellValue('D' . $rowCount, $card->getCouplingSerialNumber()); // Серийный № муфты
            $this->sheet->setCellValue('E' . $rowCount, $card->getRfidTagNo()); // № RFID-метки
            $this->sheet->setCellValue('F' . $rowCount, $card->getTaskCardOtherFieldsByTask($equipment->getTaskTypeId(), $equipment->getId())->getCommentProblemWithMark()); // Оборудование есть, проблема с меткой
            $this->sheet->setCellValue('G' . $rowCount, ($card->getAccounting() || $card->getTaskCardOtherFieldsByTask($equipment->getTaskTypeId(), $equipment->getId())->getCommentProblemWithMark()) ? 1 : 0); // Учет/Инвентаризация

            $rowCount++;
        });
    }

    public function setKitTitle(int $rowCount, string $title)
    {
        $this->sheet->setCellValue('A' . $rowCount, $title); // Наименованеие
    }

    /**
     * Получаем указанное количество пользователем
     */
    private function getCardSpecified()
    {
        $specified = $this->equipment->getTotalCardWithoutCatalog();
        // Если нет указанного количество, берем уже добавленные карточки
        if (!$specified) {
            $specified = $this->equipment->getTotalCardWithCatalog();
        }

        return $specified;
    }
}