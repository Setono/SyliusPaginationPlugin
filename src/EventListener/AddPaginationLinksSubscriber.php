<?php

declare(strict_types=1);

namespace Setono\SyliusPaginationPlugin\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class AddPaginationLinksSubscriber implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private $pageParameter;

    public function __construct(string $pageParameter)
    {
        $this->pageParameter = $pageParameter;
    }
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                'onRequest'
            ]
        ];
    }

    public function onRequest(GetResponseEvent $event): void
    {
        if(!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        if(!$request->query->has($this->pageParameter)) {
            return;
        }

        // @todo add prev/next links
    }
}
