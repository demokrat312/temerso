<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 15.06.2020
 * Time: 09:47
 */

namespace App\EventSubscriber;

use App\Classes\Log\MonologDBHandler;
use App\Entity\LogApi;
use App\Service\Log\LogApiService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\Event\TerminateEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ActionSubscriber implements EventSubscriberInterface
{
    /**
     * @var LogApiService
     */
    private $logApiService;

    /**
     * BeforeActionSubscriber constructor.
     */
    public function __construct(LogApiService $logApiService)
    {
        $this->logApiService = $logApiService;
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => [['convertJsonStringToArray'], ['writeLogApi']],
            KernelEvents::TERMINATE => ['onTerminate'],
            KernelEvents::RESPONSE => ['onResponse'],
        );
    }

    public function convertJsonStringToArray(ControllerEvent $event)
    {
        $request = $event->getRequest();

        if ($request->getContentType() != 'json' || !$request->getContent()) {
            return;
        }

        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new BadRequestHttpException('invalid json body: ' . json_last_error_msg());
        }

        $request->request->replace(is_array($data) ? $data : array());
    }

    public function writeLogApi(ControllerEvent $event)
    {
        $this->logApiService->writeRequestLog($event->getRequest());
    }

    public function onTerminate(TerminateEvent $event)
    {
        $this->logApiService->onTerminate();
    }

    public function onResponse(ResponseEvent $event)
    {
        if ($this->logApiService->hasLog()) {
            if (is_string($event->getResponse()->getContent())) {
                $content = $event->getResponse()->getContent();
            } else {
                $content = json_encode($event->getResponse()->getContent());
            }

            $this->logApiService->writeResponseLog($content, LogApi::RESPONSE_TYPE_SUCCESS);
        }
    }

}