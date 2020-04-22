<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 22.04.2020
 * Time: 21:35
 */

namespace App\Classes;

/**
 * @method  getValue()
 * Class ReferenceParent
 */
abstract class ReferenceParent
{
    public function __toString()
    {
        return $this->getValue();
    }

}