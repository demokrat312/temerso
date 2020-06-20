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

    protected function defaultResponse(array $data)
    {
        return $this->json([
            'result' => $data
        ]);
    }

    protected function errorResponse(string $message, int $code = null)
    {
        return $this->json([
            'message' => $message,
            'result' => []
        ], $code ?: self::STATUS_CODE_400);
    }
}