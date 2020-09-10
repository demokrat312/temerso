<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-09-10
 * Time: 11:28
 */

namespace App\Classes\Card;


/**
 * Интерфейс для вывода истори в карточке для связанных сущностей
 *
 * Interface CardShowHistoryInterface
 * @package App\Classes\Card
 */
interface CardShowHistoryInterface
{
    public function getTitles(): array;

    public function getFields(): array;
}