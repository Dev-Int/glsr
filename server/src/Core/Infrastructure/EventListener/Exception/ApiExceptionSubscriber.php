<?php

declare(strict_types=1);

/*
 * This file is part of the G.L.S.R. Apps package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Infrastructure\EventListener\Exception;

use Core\Domain\Exception\ApiExceptionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    private ?Request $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $apiEventException = $event->getThrowable();

        // dd((!\in_array(ApiExceptionInterface::class, \class_implements($apiEventException), true) &&
        //    !\in_array(ApiExceptionInterface::class, \class_implements($apiEventException->getPrevious()), true))
        // );
        if (!$apiEventException instanceof ApiExceptionInterface
            && !$apiEventException->getPrevious() instanceof ApiExceptionInterface
        ) {
            return;
        }

        $response = new JsonResponse(
            [
                'details' => $apiEventException->getMessage(),
                'method' => $this->request->getMethod(),
            ],
            Response::HTTP_BAD_REQUEST
        );

        $response->headers->set('Content-Type', 'application/problem+json');

        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
