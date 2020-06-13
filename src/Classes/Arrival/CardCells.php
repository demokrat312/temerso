<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 06.05.2020
 * Time: 12:55
 */

namespace App\Classes\Arrival;


use App\Classes\Excel\CellsInterface;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CardCells implements CellsInterface
{
    private $currentRow;

    /**
     * @var Worksheet
     */
    private $sheet;

    public function setActiveSheet(Worksheet $sheet)
    {
        $this->sheet = $sheet;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrentRow()
    {
        return $this->currentRow;
    }

    /**
     * @param mixed $currentRow
     * @return $this
     */
    public function setCurrentRow($currentRow)
    {
        $this->currentRow = $currentRow;
        return $this;
    }


    public function setGeneralName($value)
    {
        $this->sheet->setCellValue('A' . $this->currentRow, $value);

        return $this;
    }


    public function setPipeSerialNumber($value)
    {
        $this->sheet->setCellValue('B' . $this->currentRow, $value);

        return $this;
    }

    public function setSerialNoOfNipple($value)
    {
        $this->sheet->setCellValue('C' . $this->currentRow, $value);

        return $this;
    }

    public function setCouplingSerialNumber($value)
    {
        $this->sheet->setCellValue('D' . $this->currentRow, $value);

        return $this;
    }

    public function setOuterDiameterOfThePipe($value)
    {
        $this->sheet->setCellValue('E' . $this->currentRow, $value);

        return $this;
    }

    public function setPipeWallThickness($value)
    {
        $this->sheet->setCellValue('F' . $this->currentRow, $value);

        return $this;
    }

    public function setRefTypeDisembarkation($value)
    {
        $this->sheet->setCellValue('G' . $this->currentRow, $value);

        return $this;
    }

    public function setRefPipeStrengthGroup($value)
    {
        $this->sheet->setCellValue('H' . $this->currentRow, $value);

        return $this;
    }

    public function setRefTypeThread($value)
    {
        $this->sheet->setCellValue('I' . $this->currentRow, $value);

        return $this;
    }

    public function setOdlockNipple($value)
    {
        $this->sheet->setCellValue('J' . $this->currentRow, $value);

        return $this;
    }

    public function setDfchamferNipple($value)
    {
        $this->sheet->setCellValue('K' . $this->currentRow, $value);

        return $this;
    }

    public function setLpcThreadLengthNipple($value)
    {
        $this->sheet->setCellValue('L' . $this->currentRow, $value);

        return $this;
    }

    public function setNippleNoseDiameter($value)
    {
        $this->sheet->setCellValue('M' . $this->currentRow, $value);

        return $this;
    }

    public function setOdlockCoupling($value)
    {
        $this->sheet->setCellValue('N' . $this->currentRow, $value);

        return $this;
    }

    public function setDfchamferCoupling($value)
    {
        $this->sheet->setCellValue('O' . $this->currentRow, $value);

        return $this;
    }

    public function setLbcThreadLengthCoupler($value)
    {
        $this->sheet->setCellValue('P' . $this->currentRow, $value);

        return $this;
    }

    public function setQcBoreDiameterCoupling($value)
    {
        $this->sheet->setCellValue('Q' . $this->currentRow, $value);

        return $this;
    }

    public function setIdlockNipple($value)
    {
        $this->sheet->setCellValue('R' . $this->currentRow, $value);

        return $this;
    }

    public function setPipeLength($value)
    {
        $this->sheet->setCellValue('S' . $this->currentRow, $value);

        return $this;
    }

    public function setWeightOfPipe($value)
    {
        $this->sheet->setCellValue('T' . $this->currentRow, $value);

        return $this;
    }

    public function setShoulderAngle($value)
    {
        $this->sheet->setCellValue('U' . $this->currentRow, $value);

        return $this;
    }

    public function setTurnkeyLengthNipple($value)
    {
        $this->sheet->setCellValue('V' . $this->currentRow, $value);

        return $this;
    }

    public function setTurnkeyLengthCoupling($value)
    {
        $this->sheet->setCellValue('W' . $this->currentRow, $value);

        return $this;
    }

    public function setRefThreadCoating($value)
    {
        $this->sheet->setCellValue('X' . $this->currentRow, $value);

        return $this;
    }

    public function setRefInnerCoating($value)
    {
        $this->sheet->setCellValue('Y' . $this->currentRow, $value);

        return $this;
    }

    public function setRefHardbandingNipple($value)
    {
        $this->sheet->setCellValue('Z' . $this->currentRow, $value);

        return $this;
    }

    public function setRefHardbandingCoupling($value)
    {
        $this->sheet->setCellValue('AA' . $this->currentRow, $value);

        return $this;
    }

    public function setBtCertificateNumber($value)
    {
        $this->sheet->setCellValue('AB' . $this->currentRow, $value);

        return $this;
    }

    public function setRefWearClass($value)
    {
        $this->sheet->setCellValue('AC' . $this->currentRow, $value);

        return $this;
    }
}