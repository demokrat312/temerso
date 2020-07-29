<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 26.05.2020
 * Time: 10:48
 */

namespace App\Controller\Admin;


use App\Classes\Task\TaskAdminController;
use App\Entity\Repair;

class RepairAdminController extends TaskAdminController
{
    function getEntityClass(): string
    {
        return Repair::class;
    }

}