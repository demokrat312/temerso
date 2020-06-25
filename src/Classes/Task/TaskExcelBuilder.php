<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 24.06.2020
 * Time: 09:06
 */

namespace App\Classes\Task;


use App\Classes\Arrival\ExcelHelper;
use App\Classes\Arrival\MarkingCells;
use App\Classes\Inventory\InventoryCells;
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
        }

        $excelHelper->print();
    }

    private function getMarking(Marking $marking, ExcelHelper $excelHelper)
    {
        $excelHelper->setSource('templates/excelFile/marking_excel.xlsx');

        // Задаем общию информацию
        $markingСells = new MarkingCells();
        $markingСells
            ->setActiveSheet($excelHelper->getActiveSheet())
            ->setGeneral($marking);

        if ($marking->getCards()->count() > 0) {
            $startRow = 6;
            $markingСells
                ->duplicateRow($startRow, $marking->getCards()->count())
                ->setCars($startRow, $marking);
        }

        return true;
    }

    private function getInventory(Inventory $inventory, ExcelHelper $excelHelper)
    {
        $excelHelper->setSource('templates/excelFile/inventory_excel.xlsx');

        // Задаем общию информацию
        $markingСells = new InventoryCells();
        $markingСells
            ->setActiveSheet($excelHelper->getActiveSheet())
            ->setGeneral($inventory);

        if ($inventory->getCards()->count() > 0) {
            $startRow = 6;
            $markingСells
                ->duplicateRow($startRow, $inventory->getCards()->count())
                ->setCars($startRow, $inventory);
        }

        return true;
    }
}