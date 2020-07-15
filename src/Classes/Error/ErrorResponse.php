<?php
/**
 * Created by PhpStorm.
 * User: isusi-backend
 * Date: 30.06.2020
 * Time: 11:10
 */

namespace App\Classes\Error;

use Swagger\Annotations as SWG;


class ErrorResponse
{
    /**
     * @SWG\Property(description="Сообщение об ошибке или массив ошибок", type="string")
     * @var int
     */
    public $message;

    /**
     * @SWG\Property(description="null", type="string")
     * @var mixed
     */
    public $result;
}