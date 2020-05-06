<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 06.05.2020
 * Time: 12:55
 */

namespace App\Classes\Arrival;


use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

interface СellsInterface
{
    public function setActiveSheet(Worksheet $sheet);
}