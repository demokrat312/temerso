<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 28.05.2020
 * Time: 23:00
 */

namespace App\Service\Access;


use App\Entity\User;
use Symfony\Component\Security\Core\Security;

class RoleService
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getRole() {
        switch (true) {
            case $this->security->isGranted(User::ROLE_ADMIN):
                return User::ROLE_ADMIN;
            case $this->security->isGranted(User::ROLE_INSPECTOR):
                return User::ROLE_INSPECTOR;
            case $this->security->isGranted(User::ROLE_STOREKEEPER):
                return User::ROLE_STOREKEEPER;
            default:
                throw new \Exception('Неизвестная роль');
        }
    }
}