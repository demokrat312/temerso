<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 2020-09-13
 * Time: 13:40
 */

namespace App\Form\Data\Api\Card;

use Swagger\Annotations as SWG;


class CardImageData
{
    /**
     * Изображение
     *
     * @var string
     *
     * @SWG\Property(format="binary", property="image")
     */
    private $image;
    /**
     * Ключ задачи
     *
     * @var integer
     */
    private $taskId;
    /**
     * Тип родительской задачи
     *
     * @var integer
     */
    private $taskTypeId;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaskId()
    {
        return $this->taskId;
    }

    /**
     * @param mixed $taskId
     * @return $this
     */
    public function setTaskId($taskId)
    {
        $this->taskId = $taskId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaskTypeId()
    {
        return $this->taskTypeId;
    }

    /**
     * @param mixed $taskTypeId
     * @return $this
     */
    public function setTaskTypeId($taskTypeId)
    {
        $this->taskTypeId = $taskTypeId;
        return $this;
    }
}