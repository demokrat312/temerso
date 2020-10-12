<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-08-04
 * Time: 10:33
 */

namespace App\Form\Data\Api\Kit;


class KitCardsData
{
    /**
     * @var string|null
     */
    private $rfidTagNo;
    /**
     * @var integer|null
     */
    private $sortOrder;

    /**
     * @return string|null
     */
    public function getRfidTagNo(): ?string
    {
        return $this->rfidTagNo;
    }

    /**
     * @param string|null $rfidTagNo
     * @return $this
     */
    public function setRfidTagNo(?string $rfidTagNo)
    {
        $this->rfidTagNo = $rfidTagNo;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSortOrder(): ?int
    {
        return $this->sortOrder;
    }

    /**
     * @param int|null $sortOrder
     * @return $this
     */
    public function setSortOrder(?int $sortOrder)
    {
        $this->sortOrder = $sortOrder;
        return $this;
    }
}