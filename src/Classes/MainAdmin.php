<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 23.04.2020
 * Time: 18:32
 */

namespace App\Classes;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;

abstract class MainAdmin extends AbstractAdmin
{
    public function addIdentifier(ListMapper $listMapper, string $name)
    {
        $fieldDescriptionOptions = [
            'identifier' => true,
            'route' => ['name' => 'show']
        ];
        $listMapper->add($name, null, $fieldDescriptionOptions);
    }
}