<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 26.05.2020
 * Time: 10:48
 */

namespace App\Controller\Admin;


use App\Classes\Task\TaskAdminController;
use App\Entity\Inspection;

/**
 * 6) Инспекция/Дефектоскопия
 *
 * Class InspectionAdminController
 * @package App\Controller\Admin
 */
class InspectionAdminController extends TaskAdminController
{
    function getEntityClass(): string
    {
        return Inspection::class;
    }


}