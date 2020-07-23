<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-07-23
 * Time: 15:32
 */

namespace App\Form\Data\Api\Inventory;


use App\Entity\InventoryOver;

class InventoryData
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var InventoryOver[]
     */
    private $overList;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return InventoryOver[]
     */
    public function getOverList()
    {
        return $this->overList;
    }

    /**
     * @param mixed $overList
     * @return $this
     */
    public function setOverList($overList)
    {
        $this->overList = $overList;

        return $this;
    }
}