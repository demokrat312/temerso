<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 29.04.2020
 * Time: 00:23
 */

namespace App\Classes;


class StatusHelper
{
    const STATUS_CREATE = 1; // Создана
    const STATUS_STORE = 2; // На складе
    const STATUS_REPAIR = 3; // В ремонте
    const STATUS_RENT = 4; // В аренде
    const STATUS_TRASH = 5; // Статусы карточки в базе Списанного Оборудования (доступ к базе находится в Каталоге):
    const STATUS_BROKEN = 6; // Списано

    const STATUS_TITLE = [
        self::STATUS_CREATE => 'Создана',
        self::STATUS_STORE => 'На складе',
        self::STATUS_REPAIR => 'В ремонте',
        self::STATUS_RENT => 'В аренде',
        self::STATUS_TRASH => 'Статусы карточки в базе Списанного Оборудования (доступ к базе находится в Каталоге):',
        self::STATUS_BROKEN => 'Списано',
    ];

    static function getChoices() {
        return [
            self::STATUS_TITLE[self::STATUS_CREATE] => self::STATUS_CREATE,
            self::STATUS_TITLE[self::STATUS_STORE] => self::STATUS_STORE,
            self::STATUS_TITLE[self::STATUS_REPAIR] => self::STATUS_REPAIR,
            self::STATUS_TITLE[self::STATUS_RENT] => self::STATUS_RENT,
            self::STATUS_TITLE[self::STATUS_TRASH] => self::STATUS_TRASH,
            self::STATUS_TITLE[self::STATUS_BROKEN] => self::STATUS_BROKEN,
        ];
    }
}