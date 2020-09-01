<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 06.05.2020
 * Time: 12:55
 */

namespace App\Classes\Inventory;


use App\Classes\Excel\ParentCells;
use App\Classes\Task\TaskItemInterface;
use App\Entity\Card;
use App\Entity\Inventory;
use App\Entity\InventoryOver;
use Doctrine\Common\Collections\Collection;

class InventoryCells extends ParentCells
{
    /**
     * Дата прихода
     *
     * @param $value
     */
    public function setGeneral(TaskItemInterface $marking)
    {
        $this->sheet->setCellValue('B1', (string)$marking->getExecutor()); // Исполнитель
        $this->sheet->setCellValue('B2', $marking->getCards()->count()); // Всего единиц оборудования для маркировки
        $this->sheet->setCellValue('B3', ''); // Местонахождение инвентаризируемого комплекта
        $this->sheet->setCellValue('B4', ''); // Основание формирования комплекта
        $this->sheet->setCellValue('B7', $marking->getCards()->count()); // Всего

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
            $this->sheet->setCellValue('F' . $rowCount, ($card->getAccounting() || $card->getTaskCardOtherFieldsByTask($task)->getCommentProblemWithMark()) ? 'есть' : 'нет'); // Учет/Инвентаризация
            $this->sheet->setCellValue('G' . $rowCount, $card->getTaskCardOtherFieldsByTask($task)->getCommentProblemWithMark()); //  Оборудование есть,проблема с меткой

            $rowCount++;
        });
    }

    /**
     * Излишек
     *
     * @param Collection|Card[] $cards
     */
    public function setOver(int $startRow, Inventory $task)
    {
        $rowCount = $startRow;
        $task->getOver()->map(function(InventoryOver $over) use ($task, &$rowCount) {
            $this->sheet->setCellValue('B' . $rowCount, $over->getPipeSerialNumber()); // Серийный № трубы
            $this->sheet->setCellValue('C' . $rowCount, $over->getSerialNoOfNipple()); // Серийный № ниппеля
            $this->sheet->setCellValue('D' . $rowCount, $over->getCouplingSerialNumber()); // Серийный № муфты
            $this->sheet->setCellValue('E' . $rowCount, $over->getRfidTagNo()); // № RFID-метки
            $this->sheet->setCellValue('F' . $rowCount, $over->getComment()); // Комментарий

            $rowCount++;
        });
    }
}