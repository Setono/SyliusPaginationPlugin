<?php

declare(strict_types=1);

namespace Setono\SyliusPaginationPlugin\EventHandler;

use Pagerfanta\Pagerfanta;
use Setono\SyliusPaginationPlugin\Exception\UnexpectedEventException;
use Setono\SyliusPaginationPlugin\ParameterBag\PaginationParameterBag;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Bundle\ResourceBundle\Grid\View\ResourceGridView;
use Symfony\Component\EventDispatcher\Event;

final class ResourceControllerEventHandler implements EventHandlerInterface
{
    public function supports(Event $event): bool
    {
        if (!$event instanceof ResourceControllerEvent) {
            return false;
        }

        $resourceGridView = $event->getSubject();
        if (!$resourceGridView instanceof ResourceGridView) {
            return false;
        }

        $data = $resourceGridView->getData();
        if (!$data instanceof Pagerfanta) {
            return false;
        }

        return true;
    }

    /**
     * @param ResourceControllerEvent $event
     *
     * @return PaginationParameterBag
     */
    public function handle(Event $event): PaginationParameterBag
    {
        if (!$this->supports($event)) {
            throw new UnexpectedEventException($event, ResourceControllerEvent::class);
        }

        /** @var ResourceGridView $resourceGridView */
        $resourceGridView = $event->getSubject();

        /** @var Pagerfanta $data */
        $data = $resourceGridView->getData();

        return new PaginationParameterBag($resourceGridView->getRequestConfiguration()->getRequest(), $data->getNbResults(), $data->getMaxPerPage(), $data->getCurrentPage());
    }
}
