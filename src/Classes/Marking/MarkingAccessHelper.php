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
use App\Entity\User;

class MarkingAccessHelper
{
    const USER_TYPE_CREATOR = 'creator'; // Создатель
    const USER_TYPE_EXECUTOR = 'executor'; // Исполнитель
    const USER_TYPE_BY_ROLE = [
      User::ROLE_ADMIN => self::USER_TYPE_CREATOR,
      User::ROLE_STOREKEEPER => self::USER_TYPE_EXECUTOR,
    ];

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
        ],
        // Исполнитель. Принять на исполнение
        [
            'status' => [Marking::STATUS_SEND_EXECUTION],
            'user_type' => [self::USER_TYPE_EXECUTOR],
            'access' => [self::ACCESS_CHANGE_STATUS],
            'access_change_status' => [Marking::STATUS_ACCEPT_EXECUTION],
        ],
        // Исполнитель. Смена статуса на Отправить на проверку и Результаты Сохранены Локально
        [
            'status' => [Marking::STATUS_ACCEPT_EXECUTION],
            'user_type' => [self::USER_TYPE_EXECUTOR],
            'access' => [self::ACCESS_CHANGE_STATUS],
            'access_change_status' => [Marking::STATUS_SAVE, Marking::STATUS_CONTINUE],
        ],
    ];

    // Только для web
    private const ACCESS_WEB = [
        // Кладовщик. Только просмотр
        [
            'status' => [Marking::STATUS_CONTINUE],
            'user_type' => [self::USER_TYPE_EXECUTOR],
            'access' => [self::ACCESS_VIEW],
        ],
    ];


    /**
     * Список статусов для просмотра
     */
    static function getShowStatusAccess($userType, $accessList = self::ACCESS)
    {
        $status = [];
        foreach ($accessList as $access) {
            $hasUserType = in_array($userType, $access['user_type']);
            $hasAccessView = Utils::in_array([self::ACCESS_EDIT, self::ACCESS_VIEW], $access['access']);
            if ($hasUserType && $hasAccessView) {
                $status = array_merge($status, $access['status']);
            }
        }

        return array_unique($status);
    }


    /**
     * Список статусов для просмотра, только web
     */
    static function getShowStatusAccessWeb($userType)
    {
        return self::getShowStatusAccess($userType, array_merge(self::ACCESS, self::ACCESS_WEB));
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

    /**
     * Получаем список разрешенных статусов для смены статуса
     */
    public static function getAllowStatusChange(string $userType, int $status): array
    {

        $allowStatus = [];
        foreach (self::ACCESS as $access) {
            $hasUserType = in_array($userType, $access['user_type']);
            $hasStatus = in_array($status, $access['status']);
            $hasChangeStatus = in_array(self::ACCESS_CHANGE_STATUS, $access['access']);
            if ($hasUserType && $hasStatus && $hasChangeStatus) {
                $allowStatus = array_merge($allowStatus, $access['access_change_status']);
            }
        }

        return $allowStatus;
    }

    /**
     * @param array $roles
     * @return string|null
     */
    private static function getUserTypeByRoles(array $roles)
    {
        if (Utils::in_array([User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN], $roles)) {
            $userType = self::USER_TYPE_CREATOR;
        } else if (in_array(User::ROLE_STOREKEEPER, $roles)) {
            $userType = self::USER_TYPE_EXECUTOR;
        } else {
            $userType = null;
        }
        return $userType;
    }
}