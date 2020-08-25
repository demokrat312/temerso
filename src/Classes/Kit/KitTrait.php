<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-08-25
 * Time: 12:06
 */

namespace App\Classes\Kit;

use App\Entity\Kit;

/**
 * @mixin Kit
 */
trait KitTrait
{
    public function getChoiceTitle()
    {
        return $this->getComment() .  ' ' . $this->__toString();
    }
}