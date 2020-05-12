<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 12.05.2020
 * Time: 19:33
 */

namespace App\Classes\TraitHelper;


trait SetPropertiesTrait
{
    private function setProperties(array $propertiesValue)
    {
        if (empty($propertiesValue)) return;

        foreach ($propertiesValue as $propertyName => $propertyValue) {
            $setter = 'set' . ucfirst($propertyName);

            if (method_exists($this, $setter)) {
                $this->{$setter}($propertyValue);
            }
        }
    }
}