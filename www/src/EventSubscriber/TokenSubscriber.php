<?php

namespace App\EventSubscriber;

use App\Controller\TokenAuthenticatedController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Psr\Log\LoggerInterface;

class TokenSubscriber implements EventSubscriberInterface
{
    private $tokens;

    protected $logger;

    public function __construct($tokens, LoggerInterface $logger)
    {
        $this->tokens = $tokens;
        $this->logger = $logger;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();

        $this->logger->info('WE ALWAYS HIT TOKEN SUBSCRIBER');
        $this->logger->info('WE ALWAYS HIT TOKEN SUBSCRIBER');
        $this->logger->info('WE ALWAYS HIT TOKEN SUBSCRIBER');

        // when a controller class defines multiple action methods, the controller
        // is returned as [$controllerInstance, 'methodName']
        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof TokenAuthenticatedController) {
            $token = $event->getRequest()->query->get('token');
            if (!in_array($token, $this->tokens)) {
                throw new AccessDeniedHttpException('OMFG This action needs a valid token - '); //$this->tokens );//+ ' - ' + $token);
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}