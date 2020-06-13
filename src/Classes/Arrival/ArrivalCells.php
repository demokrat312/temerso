<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 06.05.2020
 * Time: 12:55
 */

namespace App\Classes\Arrival;


use App\Classes\Excel\CellsInterface;
use App\Entity\Card;
use Doctrine\Common\Collections\Collection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ArrivalCells implements CellsInterface
{
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
     * Дата прихода
     *
     * @param $value
     */
    public function setDateArrival($value)
    {
        $this->sheet->setCellValue('B1', $value);

        return $this;
    }

    /**
     * Основание прихода (№ договора покупки, дата покупки)
     *
     * @param $value
     */
    public function setNumberAndDatePurchase($value)
    {
        $this->sheet->setCellValue('B2', $value);

        return $this;
    }

    public function addCardRow(int $rowCount)
    {
        $rowNew = $rowCount - 1;
        $this->sheet->insertNewRowBefore(5, $rowNew);
        $this->sheet->duplicateStyle($this->sheet->getStyle('A4'), 'A5:A' . $rowNew);

        return $this;
    }

    /**
     * Итого
     *
     * @param $value
     */
    public function setTotal(int $rowCount)
    {
        $this->sheet->setCellValue('B' . (4 + $rowCount), $rowCount);

        return $this;
    }

    /**
     * @param Collection|Card[] $cards
     */
    public function setCars(Collection $cards)
    {
        $cardCell = new CardCells();
        $cardCell->setActiveSheet($this->sheet);
        $cardCell->setCurrentRow(4);

        $cards->map(function (Card $card) use ($cardCell) {
            $cardCell->setGeneralName($card->getGeneralName());
            $cardCell->setPipeSerialNumber($card->getPipeSerialNumber() ); // Серийный № трубы
            $cardCell->setSerialNoOfNipple($card->getSerialNoOfNipple() ); // Серийный № ниппеля
            $cardCell->setCouplingSerialNumber($card->getCouplingSerialNumber() ); // Серийный № муфты
            $cardCell->setOuterDiameterOfThePipe($card->getOuterDiameterOfThePipe() ); // Наружный диаметр трубы, (мм)
            $cardCell->setPipeWallThickness($card->getPipeWallThickness() ); // Толщина стенки трубы, (мм)
            $cardCell->setRefTypeDisembarkation($card->getRefTypeDisembarkation() ); // Тип высадки
            $cardCell->setRefPipeStrengthGroup($card->getRefPipeStrengthGroup() ); // Группа прочности трубы
            $cardCell->setRefTypeThread($card->getRefTypeThread() ); // Тип резьбы
            $cardCell->setOdlockNipple($card->getOdlockNipple() ); // O.D. Замка ниппель  (мм)
            $cardCell->setDfchamferNipple($card->getDfchamferNipple() ); // D.F.  Фаска ниппель (мм)
            $cardCell->setLpcThreadLengthNipple($card->getLpcThreadLengthNipple() ); // LPC   Длина резьбы ниппель (мм)
            $cardCell->setNippleNoseDiameter($card->getNippleNoseDiameter() ); // диаметр носика ниппеля
            $cardCell->setOdlockCoupling($card->getOdlockCoupling() ); // O.D. Замка муфта  (мм)
            $cardCell->setDfchamferCoupling($card->getDfchamferCoupling() ); // D.F.  Фаска муфта (мм)
            $cardCell->setLbcThreadLengthCoupler($card->getLbcThreadLengthCoupler() ); // LBC Длина резьбы муфта (мм)
            $cardCell->setQcBoreDiameterCoupling($card->getQcBoreDiameterCoupling() ); // QC Диаметр расточки муфта(мм)
            $cardCell->setIdlockNipple($card->getIdlockNipple() ); // I.D. Замка ниппель  (мм)
            $cardCell->setPipeLength($card->getPipeLength() ); // Длина трубы (м)
            $cardCell->setWeightOfPipe($card->getWeightOfPipe() ); // Вес трубы (кг)
            $cardCell->setShoulderAngle($card->getShoulderAngle() ); // угол заплечика (градус)
            $cardCell->setTurnkeyLengthNipple($card->getTurnkeyLengthNipple() ); // Длина под ключ ниппель, (мм)
            $cardCell->setTurnkeyLengthCoupling($card->getTurnkeyLengthCoupling() ); // Длина под ключ муфта, (мм)
            $cardCell->setRefThreadCoating($card->getRefThreadCoating() ); // Покрытие резьбы
            $cardCell->setRefInnerCoating($card->getRefInnerCoating() ); // Внутреннее покрытие
            $cardCell->setRefHardbandingNipple($card->getRefHardbandingNipple() ); // Хардбендинг (ниппель)
            $cardCell->setRefHardbandingCoupling($card->getRefHardbandingCoupling() ); // Хардбендинг (муфта)
            $cardCell->setBtCertificateNumber($card->getBtCertificateNumber() ); // Номер Сертификата на комплект БТ
            $cardCell->setRefWearClass($card->getRefWearClass() ); // Класс износа


            $cardCell->setCurrentRow($cardCell->getCurrentRow() + 1);
        });

        return $this;
    }
}