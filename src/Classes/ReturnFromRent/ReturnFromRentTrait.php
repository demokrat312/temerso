<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-18
 * Time: 07:36
 */

namespace App\Classes\ReturnFromRent;

use App\Entity\ReturnFromRent;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;

/**
 * Trait ReturnFromRentTrait
 * @package App\Classes\ReturnFromRent
 * @mixin ReturnFromRent
 */
trait ReturnFromRentTrait
{
    public function getCards(): Collection
    {
        if(!$this->getInspection()) {
            return new ArrayCollection();
        }

        return $this->getInspection()->getCards();
    }

    public function getUsers(): Collection
    {
        return new ArrayCollection([$this->getCreatedBy()]);
    }

    public function removeUser(User $user)
    {
        throw new Exception("Return from rend don't have handler for removeUser");
    }


}