<?php

namespace App\Classes\ReturnFromRepair;

use App\Classes\Marking\TaskEntityTrait;
use App\Entity\Marking;
use App\Entity\ReturnFromRepair;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Exception;

/**
 * Trait ReturnFromRentTrait
 * @package App\Classes\ReturnFromRent
 * @mixin ReturnFromRepair
 */
trait ReturnFromRepairTrait
{
    use TaskEntityTrait;

    public function getCards(): Collection
    {
        if(!$this->getRepair()) {
            return new ArrayCollection();
        }

        return $this->getRepair()->getCards();
    }

    public function getUsers(): Collection
    {
        return new ArrayCollection([$this->getCreatedBy()]);
    }

    public function removeUser(User $user)
    {
        throw new Exception("Return from rend don't have handler for removeUser");
    }

    public function getStatusTitle(): string
    {
        if($this->inspection) {
            return $this->getRepair()->getStatusTitle();
        }

        return Marking::STATUS_TITLE[$this->status];
    }


}