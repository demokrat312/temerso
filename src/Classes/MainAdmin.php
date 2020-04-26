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
    const VIEW_LINK = [
        'identifier' => true,
        'route' => ['name' => 'show']
    ];
}