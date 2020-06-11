<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 11.06.2020
 * Time: 09:11
 */

namespace App\Classes\Listener\CreatedBy;


use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

interface CreatedByListenerInterface
{
    /**
     * @param UserInterface|User $user
     * @return mixed
     */
    public function setCreatedBy(User $createdBy);
}