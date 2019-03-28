<?php

declare(strict_types=1);

namespace Setono\SyliusPaginationPlugin\EventHandler;

use Setono\SyliusPaginationPlugin\ParameterBag\PaginationParameterBag;
use Symfony\Component\EventDispatcher\Event;

interface EventHandlerInterface
{
    /**
     * Returns true if this handler supports the given event
     *
     * @param Event $event
     *
     * @return bool
     */
    public function supports(Event $event): bool;

    /**
     * Returns a parameter bag with data extracted from the event
     *
     * @param Event $event
     *
     * @return PaginationParameterBag
     */
    public function handle(Event $event): PaginationParameterBag;
}
