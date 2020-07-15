<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 24.06.2020
 * Time: 09:06
 */

namespace App\Classes\Task;


use App\Classes\Arrival\ExcelHelper;
use App\Classes\Equipment\EquipmentCells;
use App\Classes\Inspection\InspectionCells;
use App\Classes\Marking\MarkingCells;
use App\Classes\Inventory\InventoryCells;
use App\Entity\Equipment;
use App\Entity\EquipmentKit;
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
            case Equipment::class:
                $this->getEquipment($task, $excelHelper);
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

    private function getEquipment(Equipment $equipment, ExcelHelper $excelHelper)
    {
        $excelHelper->setSource('templates/excelFile/equipment_excel.xlsx');

        // Задаем общию информацию
        $inspectionCells = new EquipmentCells();
        $inspectionCells
            ->setActiveSheet($excelHelper->getActiveSheet())
            ->setGeneral($equipment);

        $startRow = 5;
        $rowCounter = $startRow;
        $equipment->getKits()->map(function(EquipmentKit $equipmentKit) use ($startRow, &$rowCounter, $equipment, $inspectionCells) {
            // Комплект
            if($startRow === $rowCounter) {
                $inspectionCells->setKitTitle($rowCounter, $equipmentKit->getTitle());
                $rowCounter+=2;
            } else {
//                $inspectionCells
//                    ->duplicateRow($rowCounter, 1, 'A'. $startRow);
                $inspectionCells->duplicateStyle($startRow, $rowCounter);
                $inspectionCells->setKitTitle($rowCounter, $equipmentKit->getTitle());

                $rowCounter++;
            }

            // Карточки
            $inspectionCells
                ->duplicateStyle(7 , $rowCounter)
                ->duplicateRow($rowCounter, $equipmentKit->getCards()->count())
                ->setCars($rowCounter, $equipment, $equipmentKit);
            $rowCounter += $equipmentKit->getCards()->count();
//            echo $startRow;
//            echo PHP_EOL;
        });
//exit;
        return true;
    }
}