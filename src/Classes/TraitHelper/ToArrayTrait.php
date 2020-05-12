<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 12.05.2020
 * Time: 19:49
 */

namespace App\Classes\TraitHelper;


trait ToArrayTrait
{
    public function toArray()
    {
        $allMethods = get_class_methods(static::class);
        $list = [];
        foreach ($allMethods as $methodName) {
            if (substr($methodName, 0, 3) == 'get') {
                $fieldName = lcfirst(substr($methodName, 3));
                if ($this->{$methodName}() !== null) {
                    $getterValue = $this->{$methodName}();
                    // toArray рекурсия
                    if (is_object($getterValue) && method_exists($getterValue, 'toArray')) {
                        $getterValue = $getterValue->toArray();
                    }
                    $list[$fieldName] = $getterValue;
                }
            }
        }

        return $list;
    }
}