<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-08-31
 * Time: 18:36
 */

namespace App\Classes\Inspection;


use App\Entity\Card;
use App\Entity\CardTemporary;
use App\Entity\Inspection;
use App\Entity\Marking;
use Doctrine\Common\Collections\Criteria;

/**
 * @mixin Inspection
 */
trait InspectionTrait
{
    /**
     * @see app/templates/inspection/show.html.twig
     * @return bool
     */
    public function hasAccessEditCardTemporary()
    {
        return Marking::STATUS_SAVE !== $this->getStatus() &&  in_array($this->getStatus(), Marking::STATUS_CARD_TEMPORARY);
    }
}