<?php

declare(strict_types=1);

namespace Setono\SyliusPaginationPlugin\Exception;

use Symfony\Component\EventDispatcher\Event;

final class NoSupportedHandlerException extends \RuntimeException
{
    public function __construct(Event $event)
    {
        parent::__construct(sprintf('No supported event handler for the event: %s', get_class($event)));
    }
}
