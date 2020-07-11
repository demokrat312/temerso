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

    protected $defaultColumnRange = 'I' ;

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
        $newRowInsert = $rowCount - 1;
        $nextRow = $startRow + 1;

        // Вставляем строку, после указанной
        $this->sheet->insertNewRowBefore($nextRow, $newRowInsert);
        // Копируем стили
        //$this->sheet->duplicateStyle($this->sheet->getStyle($startRowCell), $endRowCell);

        $this->duplicateStyle($startRow, $startRow, $newRowInsert );

//        echo 'from: ' . $startRowCell . '; to: '. $endRowCell;exit;

        return $this;
    }

//    public function duplicateStyle(string $rangeFrom, string $rangeTo)
    public function duplicateStyle(int $rowFrom, int $rowTo, int $count = 0)
    {
//        $this->sheet->duplicateStyle($this->sheet->getStyle($rangeFrom), $rangeTo);

        foreach ($this->columnRange() as $columnName) {
            if($columnName === $this->defaultColumnRange)break;
            $columnStyle = $this->sheet->getStyle($columnName . $rowFrom);

            for ($currentRow = $rowTo; $currentRow <= ($rowTo + $count); $currentRow++) {
                $this->sheet->duplicateStyle($columnStyle, $columnName . $currentRow );
            }
        }

        return $this;
    }

    protected function columnRange()
    {
        return ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',];
    }

}