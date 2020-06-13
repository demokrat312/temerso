<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 13.06.2020
 * Time: 16:22
 */

namespace App\Classes\Excel;


use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ParentCells implements CellsInterface
{
    /**
     * @var Worksheet
     */
    protected $sheet;

    public function setActiveSheet(Worksheet $sheet)
    {
        $this->sheet = $sheet;

        return $this;
    }

    /**
     * Клонирует определенную строку, указанное количество раз
     */
    public function duplicateRow(int $startRow, int $rowCount)
    {
        $rowNew = $rowCount - 1;
        $startRowCell = 'A' . $startRow;
        $endRowCell = 'A' . ($startRow + 1) . ':A' . $rowNew;

        // Вставляем строку
        $this->sheet->insertNewRowBefore($startRow + 1, $rowNew);
        // Копируем стили
        $this->sheet->duplicateStyle($this->sheet->getStyle($startRowCell), $endRowCell);

        return $this;
    }

}