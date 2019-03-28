<?php

declare(strict_types=1);

namespace Setono\SyliusPaginationPlugin\Exception;

use Symfony\Component\EventDispatcher\Event;

final class UnexpectedEventException extends \InvalidArgumentException
{
    public function __construct(Event $event, string $expected)
    {
        parent::__construct(sprintf('Unexpected event: %s. Expected event was: %s', get_class($event), $expected));
    }
}
