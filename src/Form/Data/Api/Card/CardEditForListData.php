<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-08-09
 * Time: 15:41
 */

namespace App\Form\Data\Api\Card;

use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;


class CardEditForListData
{
    /**
     * Ключ, карточки
     *
     * @var integer
     * @Assert\NotBlank(message="ключ, карточки. Обезательное поле")
     */
    private $id;
    /**
     * № Метки RFID
     *
     * @var string
     * @Assert\NotBlank(message="№ Метки RFID. Обезательное поле")
     * @SWG\Property(example="30 00 e2 00 9a 90 70 01 3a f0 00 00 59 61")
     */
    private $rfidTagNo;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setId(?int $id)
    {
        $this->id = $id;
        return $this;
    }

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
}