<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 06.05.2020
 * Time: 12:55
 */

namespace App\Classes\Repair;


use App\Classes\Excel\ParentCells;
use App\Classes\Task\TaskItemInterface;
use App\Entity\Card;
use Doctrine\Common\Collections\Collection;

class RepairCells extends ParentCells
{
    /**
     * Дата прихода
     *
     * @param $value
     */
    public function setGeneral(TaskItemInterface $repair)
    {
        $this->sheet->setCellValue('B1', $repair->getCreatedBy()->getFio()); // Постановщик
        $this->sheet->setCellValue('B2', $repair->getUsers()->first()->getFio()); // Исполнитель
        $this->sheet->setCellValue('B3', $repair->getCards()->count()); // Всего единиц оборудования для маркировки
        $this->sheet->setCellValue('B4', $repair->getStatusTitle()); // Статус

        return $this;
    }

    /**
     * @param Collection|Card[] $cards
     */
    public function setCars(int $startRow, TaskItemInterface $task)
    {
        $rowCount = $startRow;
        $task->getCards()->map(function(Card $card) use ($task, &$rowCount) {
            $this->sheet->setCellValue('A' . $rowCount, $card->getGeneralName()); // Наименованеие
            $this->sheet->setCellValue('B' . $rowCount, $card->getPipeSerialNumber()); // Серийный № трубы
            $this->sheet->setCellValue('C' . $rowCount, $card->getSerialNoOfNipple()); // Серийный № ниппеля
            $this->sheet->setCellValue('D' . $rowCount, $card->getCouplingSerialNumber()); // Серийный № муфты
            $this->sheet->setCellValue('E' . $rowCount, $card->getRfidTagNo()); // № RFID-метки
            $this->sheet->setCellValue('F' . $rowCount, $card->getTaskCardOtherFieldsByTask($task->getTaskTypeId(), $task->getId())->getCommentProblemWithMark()); // Оборудование есть, проблема с меткой
            $this->sheet->setCellValue('G' . $rowCount, $card->getAccounting() ? 1 : 0); // Учет/Инветаризация
            $this->sheet->setCellValue('H' . $rowCount, $card->getRepairCardImgRequiredByRepair($task)->getRequired() ? 'Фото обезательно' : ''); // Обязательность приложения фото

            $rowCount++;
        });
    }
}