<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 06.05.2020
 * Time: 12:51
 */

namespace App\Classes\Arrival;


use Onurb\Bundle\ExcelBundle\Factory\ExcelFactory;

class ExcelHelper
{
    private const ROOT_PATH = '../'; // По умолчанию папка public (/var/www/temerso/public)
    /**
     * @var ExcelFactory
     */
    private $spreadSheetService;
    /**
     * @var \PhpOffice\PhpSpreadsheet\Spreadsheet
     */
    private $spreadSheet;
    /**
     * @var \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
     */
    private $activeSheet;

    private $isSetSource = false;

    /**
     * ArrivalExcel constructor.
     */
    public function __construct(ExcelFactory $spreadSheetService)
    {
        $this->spreadSheetService = $spreadSheetService;
    }

    /**
     * Путь к файлу который будет редактировать
     *
     * @param string $pathToFile
     */
    public function setSource(string $pathToFile)
    {
        // Загружаем файл
        $this->spreadSheet = $this->spreadSheetService->createSpreadsheet(self::ROOT_PATH . $pathToFile);
        // Берем активную вкладку/страницу, т.е. первую
        $this->activeSheet = $this->spreadSheet->getActiveSheet();

        $this->isSetSource = true;
    }

    /**
     * Берем активную вкладку/страницу
     * @return \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
     */
    public function getActiveSheet(): \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
    {
        if(!$this->isSetSource) {
            throw new \Exception('Файл не указан');
        }
        return $this->activeSheet;
    }

    public function print()
    {
        $writer = $this->spreadSheetService->createWriter($this->spreadSheet, 'Xlsx');
        $fileName = 'test';
        $extension = 'Xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$fileName}.{$extension}\"");
        $writer->save('php://output');
        exit;
    }
}