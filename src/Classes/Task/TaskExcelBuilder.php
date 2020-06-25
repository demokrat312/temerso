<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 24.06.2020
 * Time: 09:06
 */

namespace App\Classes\Task;


use App\Classes\Arrival\ExcelHelper;
use App\Classes\Inspection\InspectionCells;
use App\Classes\Marking\MarkingCells;
use App\Classes\Inventory\InventoryCells;
use App\Entity\Inspection;
use App\Entity\Inventory;
use App\Entity\Marking;
use Onurb\Bundle\ExcelBundle\Factory\ExcelFactory;

class TaskExcelBuilder
{
    /**
     * @var ExcelFactory
     */
    private $excelFactory;

    /**
     * TaskExcelFactory constructor.
     */
    public function __construct(ExcelFactory $excelFactory)
    {
        $this->excelFactory = $excelFactory;
    }

    public function build(TaskItemInterface $task)
    {
        $excelHelper = new ExcelHelper($this->excelFactory);

        switch (get_class($task)) {
            case Marking::class:
                $this->getMarking($task, $excelHelper);
                break;
            case Inventory::class:
                $this->getInventory($task, $excelHelper);
                break;
            case Inspection::class:
                $this->getInspection($task, $excelHelper);
                break;
        }

        $excelHelper->print();
    }

    private function getMarking(Marking $marking, ExcelHelper $excelHelper)
    {
        $excelHelper->setSource('templates/excelFile/marking_excel.xlsx');

        // Задаем общию информацию
        $markingCells = new MarkingCells();
        $markingCells
            ->setActiveSheet($excelHelper->getActiveSheet())
            ->setGeneral($marking);

        if ($marking->getCards()->count() > 0) {
            $startRow = 6;
            $markingCells
                ->duplicateRow($startRow, $marking->getCards()->count())
                ->setCars($startRow, $marking);
        }

        return true;
    }

    private function getInventory(Inventory $inventory, ExcelHelper $excelHelper)
    {
        $excelHelper->setSource('templates/excelFile/inventory_excel.xlsx');

        // Задаем общию информацию
        $markingCells = new InventoryCells();
        $markingCells
            ->setActiveSheet($excelHelper->getActiveSheet())
            ->setGeneral($inventory);

        if ($inventory->getCards()->count() > 0) {
            $startRow = 6;
            $markingCells
                ->duplicateRow($startRow, $inventory->getCards()->count())
                ->setCars($startRow, $inventory);
        }

        return true;
    }

    private function getInspection(Inspection $inspection, ExcelHelper $excelHelper)
    {
        $excelHelper->setSource('templates/excelFile/inspection_excel.xlsx');

        // Задаем общию информацию
        $inspectionCells = new InspectionCells();
        $inspectionCells
            ->setActiveSheet($excelHelper->getActiveSheet())
            ->setGeneral($inspection);

        if ($inspection->getCards()->count() > 0) {
            $startRow = 6;
            $inspectionCells
                ->duplicateRow($startRow, $inspection->getCards()->count())
                ->setCars($startRow, $inspection);
        }

        return true;
    }
}