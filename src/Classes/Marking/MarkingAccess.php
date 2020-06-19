<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 19.06.2020
 * Time: 09:06
 */

namespace App\Classes\Marking;


use App\Classes\Utils;
use App\Entity\Marking;

class MarkingAccess
{
    const USER_TYPE_CREATOR = 'creator'; // Создатель
    const USER_TYPE_EXECUTOR = 'executor'; // Исполнитель

    private const ACCESS_EDIT = 'access_edit'; // Редактирование
    private const ACCESS_VIEW = 'access_view'; // Просмотр
    private const ACCESS_CHANGE_STATUS = 'access_change_status'; // Смена на определенный статус

    private const ACCESS = [
        // Админ. Создание или редактирование, админ может делать что хочет
        [
            'status' => [Marking::STATUS_CREATED],
            'user_type' => [self::USER_TYPE_CREATOR],
            'access' => [self::ACCESS_EDIT],
        ],
        // Админ. Просмотр на любом статусе
        [
            'status' => [Marking::STATUS_SEND_EXECUTION, Marking::STATUS_ACCEPT_EXECUTION, Marking::STATUS_SAVE, Marking::STATUS_COMPLETE, Marking::STATUS_CREATED, Marking::STATUS_REVISION,],
            'user_type' => [self::USER_TYPE_CREATOR],
            'access' => [self::ACCESS_VIEW],
        ],
        // Админ. Снять исполнителя
        [
            'status' => [Marking::STATUS_SEND_EXECUTION],
            'user_type' => [self::USER_TYPE_CREATOR],
            'access' => [self::ACCESS_CHANGE_STATUS],
            'access_change_status' => [Marking::STATUS_CREATED],
        ],
        // Кладовщик. Только просмотр
        [
            'status' => [Marking::STATUS_SEND_EXECUTION, Marking::STATUS_ACCEPT_EXECUTION, Marking::STATUS_REVISION],
            'user_type' => [self::USER_TYPE_EXECUTOR],
            'access' => [self::ACCESS_VIEW],
            'access_change_status' => [Marking::STATUS_CREATED],
        ],
    ];


    /**
     * Список статусов для просмотра
     */
    static function getShowStatusAccess($userType)
    {
        $status = [];
        foreach (self::ACCESS as $access) {
            $hasUserType = in_array($userType, $access['user_type']);
            $hasAccessView = Utils::in_array([self::ACCESS_EDIT, self::ACCESS_VIEW], $access['access']);
            if ($hasUserType && $hasAccessView) {
                $status = array_merge($status, $access['status']);
            }
        }

        return array_unique($status);
    }

    private static function roleHierarchical(string $roleName)
    {
        $roles = [$roleName];
        switch ($roleName) {
            case self::ACCESS_EDIT:
                $roles = array_merge($roles, [self::ACCESS_VIEW, self::ACCESS_CHANGE_STATUS]);
        }

        return $roles;
    }
}