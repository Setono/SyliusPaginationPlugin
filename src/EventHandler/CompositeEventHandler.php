<?php

declare(strict_types=1);

namespace Setono\SyliusPaginationPlugin\EventHandler;

use Setono\SyliusPaginationPlugin\Exception\NoSupportedHandlerException;
use Setono\SyliusPaginationPlugin\ParameterBag\PaginationParameterBag;
use Symfony\Component\EventDispatcher\Event;

final class CompositeEventHandler implements EventHandlerInterface
{
    /**
     * @var EventHandlerInterface[]
     */
    private $eventHandlers;

    public function __construct(EventHandlerInterface ...$eventHandlers)
    {
        $this->eventHandlers = $eventHandlers;
    }

    public function supports(Event $event): bool
    {
        foreach ($this->eventHandlers as $eventHandler) {
            if ($eventHandler->supports($event)) {
                return true;
            }
        }

        return false;
    }

    public function handle(Event $event): PaginationParameterBag
    {
        foreach ($this->eventHandlers as $eventHandler) {
            if ($eventHandler->supports($event)) {
                return $eventHandler->handle($event);
            }
        }

        throw new NoSupportedHandlerException($event);
    }
}
