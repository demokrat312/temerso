<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 28.05.2020
 * Time: 16:58
 */

namespace App\Service\Access;


use App\Entity\Marking;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;

class MarkingAccessService
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function checkEdit(int $status)
    {
        if ($this->security->isGranted([User::ROLE_ADMIN]) && $status === Marking::STATUS_CREATED) {
            return true;
        }

        return false;
    }
}