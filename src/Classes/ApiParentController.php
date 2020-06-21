<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 20.06.2020
 * Time: 14:14
 */

namespace App\Classes;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class ApiParentController extends AbstractController
{
    const STATUS_CODE_400 = 400; // Client sent an invalid request
    const STATUS_CODE_403 = 403; // Access denied
    const OK = 'OK!';

    protected function defaultResponse($data)
    {
        return $this->json([
            'result' => $data
        ]);
    }

    protected function errorResponse(string $message, int $code = null)
    {
        return $this->json([
            'message' => $message,
            'result' => null
        ], $code ?: self::STATUS_CODE_400);
    }

    protected function errorParamResponse()
    {
        return $this->errorResponse('Отсутсвуют необходимые параметры');
    }
}