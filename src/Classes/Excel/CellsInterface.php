<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 06.05.2020
 * Time: 12:55
 */

namespace App\Classes\Excel;


use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

interface CellsInterface
{
    public function setActiveSheet(Worksheet $sheet);
}