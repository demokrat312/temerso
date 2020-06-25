<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 06.05.2020
 * Time: 12:55
 */

namespace App\Classes\Marking;


use App\Classes\Excel\ParentCells;
use App\Classes\Task\TaskItemInterface;
use App\Entity\Card;
use Doctrine\Common\Collections\Collection;

class MarkingCells extends ParentCells
{
    /**
     * Дата прихода
     *
     * @param $value
     */
    public function setGeneral(TaskItemInterface $marking)
    {
        $this->sheet->setCellValue('B1', $marking->getCreatedBy()->getFio()); // Постановщик
        $this->sheet->setCellValue('B2', $marking->getUsers()->first()->getFio()); // Исполнитель
        $this->sheet->setCellValue('B3', $marking->getCards()->count()); // Всего единиц оборудования для маркировки
        $this->sheet->setCellValue('B4', $marking->getStatusTitle()); // Статус

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
            $this->sheet->setCellValue('E' . $rowCount, $card->getOuterDiameterOfThePipe()); // Наружный диаметр трубы, (мм)
            $this->sheet->setCellValue('F' . $rowCount, $card->getRfidTagNo()); // № RFID-метки
            $this->sheet->setCellValue('G' . $rowCount, $card->getTaskCardOtherFieldsByTask($task)->getComment()); // Примечание

            $rowCount++;
        });
    }
}