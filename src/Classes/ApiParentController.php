<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 20.06.2020
 * Time: 14:14
 */

namespace App\Classes;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;

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

    protected function errorResponse(string $message, int $code = null, array $otherError = [])
    {
        return $this->json(array_merge([
            'message' => $message,
            'result' => null
        ], $otherError), $code ?: self::STATUS_CODE_400);
    }

    public function formErrorResponse(FormInterface $form)
    {
        $errors = [];

        foreach ($form->all() as $child) {
            $errors = array_merge(
                $errors,
                $this->buildErrorArray($child)
            );
        }

        foreach ($form->getErrors() as $error) {
            if ($error->getCause()) {
                $errors[$error->getCause()->getPropertyPath()] = $error->getMessage();
            } else {
                $errors[] = $error->getMessage();
            }
        }

        return $this->errorResponse('Ошибка проверки формы', null, ['formError' => $errors]);
    }

    protected function errorParamResponse()
    {
        return $this->errorResponse('Отсутсвуют необходимые параметры');
    }

    private function buildErrorArray(FormInterface $form)
    {
        $errors = [];

        foreach ($form->all() as $child) {
            $errors = array_merge(
                $errors,
                $this->buildErrorArray($child)
            );
        }

        foreach ($form->getErrors() as $error) {
            if ($error->getCause()) {
                $errors[$error->getCause()->getPropertyPath()] = $error->getMessage();
            } else {
                $errors[] = $error->getMessage();
            }
        }

        return $errors;
    }
}