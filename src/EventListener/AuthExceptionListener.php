<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 20.05.2020
 * Time: 13:56
 */

namespace App\EventListener;


use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;

class AuthExceptionListener implements EventSubscriberInterface
{
    const ERROR_NAME = 'AuthenticationFailure';
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return array(
            AuthenticationEvents::AUTHENTICATION_FAILURE => 'onAuthenticationFailure',
        );
    }

    public function onAuthenticationFailure(AuthenticationFailureEvent $event)
    {
        $this->logger->error(self::ERROR_NAME . ':' . $event->getAuthenticationException()->getMessage());
    }
}