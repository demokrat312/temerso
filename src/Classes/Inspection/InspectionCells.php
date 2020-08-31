<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 06.05.2020
 * Time: 12:55
 */

namespace App\Classes\Inspection;


use App\Classes\Excel\ParentCells;
use App\Classes\Task\TaskItemInterface;
use App\Entity\Card;
use Doctrine\Common\Collections\Collection;

class InspectionCells extends ParentCells
{
    /**
     * Дата прихода
     *
     * @param $value
     */
    public function setGeneral(TaskItemInterface $marking)
    {
        $this->sheet->setCellValue('B1', $marking->getCreatedBy()->getFio()); // Постановщик
        $this->sheet->setCellValue('B2', $marking->getUsers()->first()->getFio()); // Исполнитель
        $this->sheet->setCellValue('B3', $marking->getCards()->count()); // Всего единиц оборудования для маркировки
        $this->sheet->setCellValue('B4', $marking->getStatusTitle()); // Статус

        return $this;
    }

    /**
     * @param Collection|Card[] $cards
     */
    public function setCars(int $startRow, TaskItemInterface $task)
    {
        $rowCount = $startRow;
        $task->getCards()->map(function(Card $card) use ($task, &$rowCount) {
            $this->sheet->setCellValue('A' . $rowCount, $card->getGeneralName()); // Наименованеие
            $this->sheet->setCellValue('B' . $rowCount, $card->getPipeSerialNumber()); // Серийный № трубы
            $this->sheet->setCellValue('C' . $rowCount, $card->getSerialNoOfNipple()); // Серийный № ниппеля
            $this->sheet->setCellValue('D' . $rowCount, $card->getCouplingSerialNumber()); // Серийный № муфты
            $this->sheet->setCellValue('E' . $rowCount, $card->getRfidTagNo()); // № RFID-метки
            $this->sheet->setCellValue('F' . $rowCount, $card->getTaskCardOtherFieldsByTask($task   )->getCommentProblemWithMark()); // Оборудование есть, проблема с меткой
            $this->sheet->setCellValue('G' . $rowCount, $card->getTaskCardOtherFieldsByTask($task)->getComment()); // Комментарий
            $this->sheet->setCellValue('H' . $rowCount, $card->getRefWearClass()); // Класс износа
            $this->sheet->setCellValue('I' . $rowCount, $card->getOuterDiameterOfThePipe()); // Наружный диаметр трубы, (мм)
            $this->sheet->setCellValue('J' . $rowCount, $card->getPipeWallThickness()); // Толщина стенки трубы, (мм)
            $this->sheet->setCellValue('K' . $rowCount, $card->getRefTypeThread()); // Тип резьбы
            $this->sheet->setCellValue('L' . $rowCount, $card->getOdlockNipple()); // O.D. Замка ниппель  (мм)
            $this->sheet->setCellValue('M' . $rowCount, $card->getOdlockCoupling()); // O.D. Замка муфта  (мм)
            $this->sheet->setCellValue('N' . $rowCount, $card->getTurnkeyLengthNipple()); // Длина под ключ ниппель, (мм)
            $this->sheet->setCellValue('O' . $rowCount, $card->getTurnkeyLengthCoupling()); // Длина под ключ муфта, (мм)
            $this->sheet->setCellValue('P' . $rowCount, $card->getRefVisualControl()); // Визуальный контроль состояния внутреннего покрытия
            $this->sheet->setCellValue('Q' . $rowCount, $card->getDepthOfNaminov()); // Глубина наминов в зоне работы клиньев max (мм)
            $this->sheet->setCellValue('R' . $rowCount, $card->getNippleEndBendMax()); // Изгиб ниппельного конца max (мм)
            $this->sheet->setCellValue('S' . $rowCount, $card->getCouplingEndBendMax()); // Изгиб муфтового конца max (мм)
            $this->sheet->setCellValue('T' . $rowCount, $card->getTheTotalBendOfThePipeBodyMax()); // Общий изгиб тела трубы max (мм)
            $this->sheet->setCellValue('U' . $rowCount, $card->getRefIpcWedgeZoneAndLandingZone()); // МПК зоны клинев и зоны высадки
            $this->sheet->setCellValue('V' . $rowCount, $card->getRefUltrasonicTesting()); // УЗК зоны клиньев и зоны высадки
            $this->sheet->setCellValue('W' . $rowCount, $card->getRefEmiBodyPipes()); // EMI тела трубы (багги)
            $this->sheet->setCellValue('X' . $rowCount, $card->getRefPipeBodyClass()); // Класс тела трубы
            $this->sheet->setCellValue('Y' . $rowCount, $card->getRefNippleThread()); // Контроль шага резьбы ниппеля плоским шаблоном
            $this->sheet->setCellValue('Z' . $rowCount, $card->getRefNippleThreadCondition()); // Состояние резьбы ниппеля
            $this->sheet->setCellValue('AA' . $rowCount, $card->getRefStatePersistent()); // Состояние упорных торцев ниппеля
            $this->sheet->setCellValue('AB' . $rowCount, $card->getRefIpcThreadNipple()); // МПК резьбы ниппеля
            $this->sheet->setCellValue('AC' . $rowCount, $card->getRefHardbendingNippleState()); // Хардбендиг ниппель (состояние)
            $this->sheet->setCellValue('AD' . $rowCount, $card->getHardbandingNipplemmDiameter()); // Хардбендиг ниппель (диаметр) мм
            $this->sheet->setCellValue('AE' . $rowCount, $card->getHardbandingNippleHeight()); // Хардбендиг ниппель (высота наплавки) мм
            $this->sheet->setCellValue('AF' . $rowCount, $card->getRefLockClassNipple()); // Класс замка ниппель
            $this->sheet->setCellValue('AG' . $rowCount, $card->getRefCouplingThreadCondition()); // Состояние резьбы муфты
            $this->sheet->setCellValue('AH' . $rowCount, $card->getRefStatusCouplingEndFaces()); // Состояние упорных торцев муфты
            $this->sheet->setCellValue('AI' . $rowCount, $card->getRefIpcThreadCoupling()); // МПК резьбы муфты
            $this->sheet->setCellValue('AJ' . $rowCount, $card->getRefUzkThreadCoupling()); // УЗК резьбы муфты
            $this->sheet->setCellValue('AK' . $rowCount, $card->getRefHardbendigCouplingState()); // Хардбендиг муфта (состояние)
            $this->sheet->setCellValue('AL' . $rowCount, $card->getHardbandingCouplerDiameter()); // Хардбендиг муфта (диаметр) мм
            $this->sheet->setCellValue('AM' . $rowCount, $card->getHardbandingCouplingHeightMm()); // Хардбендиг муфта (высота наплавки) мм
            $this->sheet->setCellValue('AN' . $rowCount, $card->getLockClassCoupling()); // Класс замка муфта

            $rowCount++;
        });
    }
}