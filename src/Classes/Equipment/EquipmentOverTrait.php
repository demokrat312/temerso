<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-09-06
 * Time: 19:30
 */

namespace App\Classes\Equipment;


use App\Entity\EquipmentOver;
use stdClass;

/**
 * @mixin EquipmentOver
 */
trait EquipmentOverTrait
{
    public function getGeneralName() {
        return '';
    }

    public function getAccounting() {
        return 0;
    }

    public function getImages() {
        return [];
    }

    public function getTaskCardOtherFieldsByTask() {
        $otherFields = new StdClass();
        $otherFields->comment = $this->getComment();
        $otherFields->commentProblemWithMark = $this->getCommentProblemWithMark();

        return $otherFields;
    }
}