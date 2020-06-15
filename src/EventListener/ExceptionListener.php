<?php
// src/EventListener/ExceptionListener.php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $this->apiException($event);
        return;
        // You get the exception object from the received event
        $exception = $event->getThrowable();
        $message = sprintf(
            'My Error says: %s with code: %s',
            $exception->getMessage(),
            $exception->getCode()
        );

        // Customize your response object to display the exception details
        $response = new Response();
        $response->setContent($message);

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // sends the modified response object to the event
        $event->setResponse($response);
    }

    private function apiException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $request   = $event->getRequest();

        if (in_array('application/json', $request->getAcceptableContentTypes())) {
            $response = $this->createApiResponse($exception);
            $event->setResponse($response);
        }
    }

    /**
     * Creates the ApiResponse from any Exception
     *
     * @param \Exception $exception
     *
     * @return JsonResponse
     */
    private function createApiResponse(\Throwable $exception)
    {
        $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;

        return new JsonResponse([
            'message' => $exception->getMessage()
        ], $statusCode);
    }
}
