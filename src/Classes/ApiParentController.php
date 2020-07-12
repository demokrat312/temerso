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
use Symfony\Component\Serializer\SerializerInterface;

abstract class ApiParentController extends AbstractController
{
    const STATUS_CODE_400 = 400; // Client sent an invalid request
    const STATUS_CODE_403 = 403; // Access denied
    const OK = 'OK!';

    const GROUP_API_DEFAULT = 'default_api';
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * ApiParentController constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }


    protected function defaultResponse($data)
    {
        return $this->json($data);
    }

    protected function errorResponse(string $message, int $code = null, array $otherError = [])
    {
        return $this->json(array_merge([
            'message' => $message,
            'result' => null
        ], $otherError), $code ?: self::STATUS_CODE_400);
    }

    protected function toArray($data, $groups)
    {
        return $this->serializer->normalize($data,null, ['groups' => $groups]);
    }

    public function formErrorResponse(FormInterface $form)
    {
        $errors = $this->buildErrorArray($form);

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