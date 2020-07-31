<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-29
 * Time: 11:52
 */

namespace App\Classes\Repair;

use App\Entity\Repair;

/**
 * @mixin Repair
 */
trait RepairTrait
{
    public function getChoiceTitle()
    {
        return sprintf('%s %s. %s.',
            $this->getId(),
            $this->getComment(),
            $this->getUpdateAt()->format('Y-m-d'),
            );
    }
}